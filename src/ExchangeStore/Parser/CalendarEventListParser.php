<?php
/**
 * CalendarEventListParser.php
 *
 * Holds the CalendarEventListParser class
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
 * The CalendarEventListParser class is responsible for parsing the
 * list of events
 *
 * PHP Version: 5
 *
 * @category Class
 * @package  Parser
 * @author   meza <meza@meza.hu>
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 */
class CalendarEventListParser implements Parser
{


    /**
     * Parses the xml
     *
     * @param string $xmlString The xml string to parse
     *
     * @return CalendarEvent[]
     */
    public function parse($xmlString)
    {
        /*
            TODO This should be fixed. SimpleXML Error handling depends on the
            environment.
        */

        libxml_use_internal_errors(true);
        $xml = new \SimpleXMLElement($xmlString);
        $xml->registerXPathNamespace('dav', 'DAV:');
        $xml->registerXPathNamespace('d', 'urn:schemas:calendar:');
        $xml->registerXPathNamespace('e', 'urn:schemas:httpmail:');

        $events = $xml->xpath('//dav:propstat/*');
        if (false === $events) {
            return array();
        }

        $result = array();
        foreach ($events as $eventIndex => $eventValue) {
            if ($eventValue->getName() === 'prop') {
                $properties = $eventValue->xpath('*');
                $event      = new CalendarEvent();

                foreach ($properties as $prop) {
                    $this->_setUpEvent($event, $prop);
                }

                $result[md5(basename($event->getUrl()))] = $event;
            }
        }//end foreach

        return array_reverse($result);

    }//end parse()


    /**
     * Populates a reference to an event, with data regarding the property
     *
     * @param CalendarEvent    $event      The event to populate
     * @param\SimpleXMLElement $xmlElement The property to consider
     *
     * @return void
     */
    private function _setUpEvent(
        CalendarEvent $event,
       \SimpleXMLElement $xmlElement
    ) {
        switch ($xmlElement->getName())
        {
        case 'href':
            $event->setUrl((string) $xmlElement);
            break;
        case 'dtstart':
            $event->from((string) $xmlElement);
            break;
        case 'dtend':
                $event->to((string) $xmlElement);
            break;
        case 'location':
            $event->at((string) $xmlElement);
            break;
        case 'subject':
            $event->withSubject((string) $xmlElement);
            break;
        case 'htmldescription':
            $event->withDescription((string) $xmlElement);
            break;
        }

    }//end _setUpEvent()


}//end class

?>
