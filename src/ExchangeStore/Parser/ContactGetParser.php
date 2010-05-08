<?php
/**
 * ContactGetParser.php
 *
 * Holds the ContactGetParser class
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

/**
 * The ContactGetParser class is responsible for parsing the received contact
 *
 * PHP Version: 5
 *
 * @category Class
 * @package  Parser
 * @author   meza <meza@meza.hu>
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 */
class ContactGetParser implements Parser
{

    /**
     * Parses the xml
     * @param string $xmlString The xml string to parse
     * @return <type>
     */
    public function parse($xmlString)
    {
        /*
            TODO This should be fixed. SimpleXML Error handling depends on the
            environment.
        */

        libxml_use_internal_errors(true);
        $xml = new SimpleXMLElement($xmlString);
        $xml->registerXPathNamespace('dav', 'DAV:');
        $xml->registerXPathNamespace('d', 'urn:schemas:contacts:');
        $root = $xml->xpath('//d:*');

        $contact = new Contact();

        foreach ($root as $value)
        {
            switch($value->getName()) {
                case 'sn':
                    $contact->lastName = (string)$value;
                    break;
                case 'givenName':
                    $contact->firstName = (string)$value;
                    break;
                case 'middlename':
                    $contact->middleName = (string)$value;
                    break;
                case 'nickname':
                    $contact->nickName = (string)$value;
                    break;
                case 'email1':
                    $contact->emailAddress = filter_var((string)$value, FILTER_SANITIZE_EMAIL);
                    break;
                default:
//                    var_dump($value->getName());
            }
        }

        return $contact;

    }//end parse()


}//end class

?>
