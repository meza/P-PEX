<?php
/**
 * TaskListHttpParam.php
 *
 * Holds the TaskListHttpParam class
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

/**
 * The TaskListHttpParam class is the http preset for
 * task listing
 *
 * PHP Version: 5
 *
 * @category Class
 * @package  ExchangeStore
 * @author   meza <meza@meza.hu>
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 */
class TaskListHttpParam extends HttpParams
{

    /**
     * @var string The root url
     */
    public $url = URLFactory::TASK;

    /**
     * @var array The headers to use for the request
     */
    public $headers = array(
                       'Content-Type' => 'text/xml',
                       'Depth'        => 1,
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
<a:searchrequest
xmlns:a="DAV:"
xmlns:mapi="http://schemas.microsoft.com/mapi/">
<a:sql>SELECT
"DAV:href",
"urn:schemas:mailheader:to",
"http://schemas.microsoft.com/exchange/x-priority-long",
"http://schemas.microsoft.com/mapi/commonstart",
"http://schemas.microsoft.com/mapi/commonend",
"http://schemas.microsoft.com/mapi/commondue",
"urn:schemas:calendar:location",
"urn:schemas:httpmail:textdescription",
"urn:schemas:httpmail:htmldescription",
"urn:schemas:httpmail:subject"
FROM "'.$this->preparedUrl.'"
</a:sql>
</a:searchrequest>';
    }//end __construct()


}//end class

?>
