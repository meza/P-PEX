<?php
/**
 * CalendarEventCreateHttpParam.php
 *
 * Holds the CalendarEventCreateHttpParam class
 *
 * PHP Version: 5
 *
 * @category File
 * @package  ExchangeStore
 * @author   meza <meza@meza.hu>
 * @license  GPL3.0
 *                    GNU GENERAL PUBLIC LICENSE
 *                       Version 3, 29 June 2007
 *
 * Copyright (C) 2007 Free Software Foundation, Inc. <http://fsf.org/>
 * Everyone is permitted to copy and distribute verbatim copies
 * of this license document, but changing it is not allowed.
 * * 
 * @link     http://www.assembla.com/spaces/p-pex
 */
//namespace Pex\ExchangeStore\HttpParams;
namespace Pex;
/**
 * The CalendarEventCreateHttpParam class is responsible for creating Calendar
 * items
 *
 * PHP Version: 5
 *
 * @category Class
 * @package  ExchangeStore
 * @author   meza <meza@meza.hu>
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 */
class CalendarEventCreateHttpParam extends HttpParams
{

    /**
     * @var string The root url
     */
    public $url = ExchangeStoreURLFactory::CALENDAR;

    /**
     * @var array The headers to use for the request
     */
    public $headers = array(
                       'Content-Type' => 'text/xml',
                       'Depth'        => 0,
                       'Translate'    => 'f',
                      );

    /**
     * @var string The http method to use
     */
    public $httpMethod = 'post';

    /**
     * @var string The custom http method to use
     */
    public $customMethod = 'PROPPATCH';


    /**
     * Creates a caledar event creator request
     *
     * @param CalendarEvent $event    The event to store
     * @param string        $username The username
     *
     * @return CalendarEventCreateHttpParam
     */
    public function __construct(CalendarEvent $event, $username)
    {
        $name = $event->getFileAsName().$event->getUrlModifier();
        $this->urlParams = array($this->_prepareName($name));
        $this->data      = '<?xml version="1.0"?>
<g:propertyupdate xmlns:g="DAV:"
    xmlns:e="http://schemas.microsoft.com/exchange/"
    xmlns:mapi="http://schemas.microsoft.com/mapi/"
    xmlns:cal="urn:schemas:calendar:"
    xmlns:dt="urn:uuid:c2f41010-65b3-11d1-a29f-00aa00c14882/"
    xmlns:header="urn:schemas:mailheader:"
    xmlns:mail="urn:schemas:httpmail:">
    <g:set>
        <g:prop>
            <g:contentclass>urn:content-classes:appointment</g:contentclass>
            <e:outlookmessageclass>IPM.Appointment</e:outlookmessageclass>
            <mapi:finvited dt:dt="boolean">1</mapi:finvited>
            <cal:instancetype dt:dt="int">0</cal:instancetype>
            <cal:busystatus>BUSY</cal:busystatus>
            <cal:meetingstatus>CONFIRMED</cal:meetingstatus>
            <cal:alldayevent dt:dt="boolean">0</cal:alldayevent>
            <cal:responserequested dt:dt="boolean">1</cal:responserequested>
            <cal:reminderoffset dt:dt="int">900</cal:reminderoffset>
            <header:to>'.$username.'</header:to>
            <mail:subject>'.$event->subject.'</mail:subject>
            <mail:htmldescription>'.$event->description.'</mail:htmldescription>
            <cal:location>'.$event->location.'</cal:location>
            <cal:dtstart dt:dt="dateTime.tz">'.$event->getStartDate('c').'</cal:dtstart>
            <cal:dtend dt:dt="dateTime.tz">'.$event->getEndDate('c').'</cal:dtend>
        </g:prop>
    </g:set>
</g:propertyupdate>';

    }//end __construct()


    /**
     * Converts the name
     *
     * @param string $name The name
     *
     * @return string
     */
    private function _prepareName($name)
    {
        return urlencode($name);

    }//end _prepareName()


}//end class

?>
