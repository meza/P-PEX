<?php
/**
 * ContactListParser.php
 *
 * Holds the ContactListParser class
 *
 * PHP Version: 5
 *
 * @category File
 * @package  Parser
 * @author   meza <meza@meza.hu>
 * @license  GPL3.0
 *                    GNU GENERAL PUBLIC LICENSE
 *                       Version 3, 29 June 2007
 *
 * Copyright (C) 2007 Free Software Foundation, Inc. <http://fsf.org/>
 * Everyone is permitted to copy and distribute verbatim copies
 * of this license document, but changing it is not allowed.
 *
 * @link     http://www.assembla.com/spaces/p-pex
 */
 //namespace Pex\ExchangeStore\Parser;
namespace Pex;
/**
 * The ContactListParser class is responsible for parsing the received contact
 * list
 *
 * PHP Version: 5
 *
 * @category Class
 * @package  Parser
 * @author   meza <meza@meza.hu>
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 */
class ContactListParser implements Parser
{

    /**
     * Parses the xml
     *
     * @param string $xmlString The xml string to parse
     *
     * @return Task[]
     */
    public function parse($xmlString)
    {
        libxml_use_internal_errors(true);
        $xml = new \SimpleXMLElement($xmlString);
        $xml->registerXPathNamespace('dav', 'DAV:');
        $xml->registerXPathNamespace('c', 'urn:schemas:contacts:');
        $xml->registerXPathNamespace('e', 'urn:schemas:httpmail:');
        $xml->registerXPathNamespace('mapi', 'http://schemas.microsoft.com/mapi/');

        $contacts = $xml->xpath('//dav:propstat/*[text()=\'HTTP/1.1 200 OK\']/../dav:prop');
        if (false === $contacts) {
            return array();
        }

        $result = array();
        foreach ($contacts as $contactIndex => $contactValue) {
            $properties = $contactValue->xpath('*');
            $contact       = new Contact();

            foreach ($properties as $prop) {
                $this->_setUpTask($contact, $prop);
            }

            $result[] = $contact;
        }//end foreach

        return array_reverse($result);

    }//end parse()


    /**
     * Populates a reference to an contact, with data regarding the property
     *
     * @param Contact          $contact       The task to populate
     * @param\SimpleXMLElement $xmlElement The property to consider
     *
     * @return void
     */
    private function _setUpTask(
        Contact $contact,
       \SimpleXMLElement $xmlElement
    ) {
        switch (strtolower($xmlElement->getName()))
        {
        case 'href':
            $contact->setUrl((string) $xmlElement);
            break;
        case 'givenname':
            $contact->firstName = (string) $xmlElement;
            break;
        case 'sn':
            $contact->lastName = (string) $xmlElement;
            break;
        case 'middlename':
            $contact->middleName = (string) $xmlElement;
            break;
        case 'fileas':
            break;
        case 'nickname':
            $contact->nickName = (string) $xmlElement;
            break;
        case 'email1emailaddress':
            $contact->emailAddress = (string) $xmlElement;
            break;
        }//end switch

    }//end _setUpTask()


}//end class

?>
