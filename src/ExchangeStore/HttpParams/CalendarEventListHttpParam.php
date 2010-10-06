<?php
/**
 * CalendarEventListHttpParam.php
 *
 * Holds the CalendarEventListHttpParam class
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
 * 
 * @link     http://www.assembla.com/spaces/p-pex
 */
//namespace Pex\ExchangeStore\HttpParams;
namespace Pex;
/**
 * The CalendarEventListHttpParam class is the http preset for
 * calendar event listing
 *
 * PHP Version: 5
 *
 * @category Class
 * @package  ExchangeStore
 * @author   meza <meza@meza.hu>
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 */
class CalendarEventListHttpParam extends HttpParams
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
    public $customMethod = 'search';


    /**
     * Creates a login param object
     *
     * @return ServiceUrlsHttpParams
     */
    public function __construct()
    {
        $this->data = '<?xml version="1.0"?>
<g:searchrequest xmlns:g="DAV:">
<g:sql>SELECT "DAV:href",
"urn:schemas:calendar:busystatus",
"urn:schemas:httpmail:subject",
"urn:schemas:httpmail:textdescription",
"urn:schemas:httpmail:htmldescription",
"urn:schemas:calendar:dtstart",
"urn:schemas:calendar:dtend",
"urn:schemas:calendar:created",
"urn:schemas:calendar:duration",
"urn:schemas:calendar:location"
FROM scope(\'shallow traversal of "'.$this->preparedUrl.'"\')
</g:sql>
</g:searchrequest>
';

    }//end __construct()


}//end class

?>
