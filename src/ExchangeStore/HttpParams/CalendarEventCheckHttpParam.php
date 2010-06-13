<?php
/**
 * CalendarEventCheckHttpParam.php
 *
 * Holds the CalendarEventCheckHttpParams class
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

/**
 * The CalendarEventCheckHttpParam class finds the first available url for the contact
 *
 * PHP Version: 5
 *
 * @category Class
 * @package  ExchangeStore
 * @author   meza <meza@meza.hu>
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 */
class CalendarEventCheckHttpParam extends HttpParams
{

    /**
     * @var string The root url
     */
    public $url = URLFactory::CALENDAR;

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
    public $customMethod = 'propfind';


    /**
     * Creates a contact finder param object
     *
     * @param CalendarEvent $event The event to check
     *
     * @return CalendarEventCheckHttpParam
     */
    public function __construct(CalendarEvent $event)
    {
        $name = $event->getFileAsName().$event->getUrlModifier();

        $this->urlParams = array($this->_prepareName($name));

        $this->data = '<?xml version="1.0"?>
<D:propfind xmlns:D="DAV:" xmlns:e="urn:schemas:calendar:">
        <D:allprop/>
</D:propfind>
';

    }//end __construct()


    /**
     * Prepares the name for the url.
     * Performs an urlencode
     *
     * @param string $name The contact's name
     *
     * @return string
     */
    private function _prepareName($name)
    {
        return urlencode($name);

    }//end _prepareName()


}//end class

?>
