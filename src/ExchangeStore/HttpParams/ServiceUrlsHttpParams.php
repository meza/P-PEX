<?php
/**
 * ServiceUrlsHttpParams.php
 *
 * Holds the ServiceUrlsHttpParams class
 *
 * PHP Version: 5
 *
 * @category File
 * @package
 * @author   meza
 * @license  GPL3.0
 *                    GNU GENERAL PUBLIC LICENSE
 *                       Version 3, 29 June 2007
 *
 * Copyright (C) 2007 Free Software Foundation, Inc. <http://fsf.org/>
 * Everyone is permitted to copy and distribute verbatim copies
 * of this license document, but changing it is not allowed.
 * * 
 * @version  GIT: $Id$
 * @link     http://www.assembla.com/spaces/p-pex
 */

require_once dirname(__FILE__).'/../../Http/HttpParams.php';

/**
 * The ServiceUrlsHttpParams class is responsible for ...
 *
 * PHP Version: 5
 *
 * @category Class
 * @package  
 * @author   meza
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 */
class ServiceUrlsHttpParams extends HttpParams
{
    public $url     = URLFactory::USERROOT;
    public $headers = array(
            'Content-Type' => 'text/xml',
            'Depth'        => 0,
            'Translate'    => 'f',
        );

    public $httpMethod = 'post';

    public $customMethod = 'propfind';

    /**
     * Creates a login param object
     *
     * @return ServiceUrlsHttpParams
     */
    public function __construct()
    {
        $this->data = <<<END
<?xml version="1.0"?>
<D:propfind xmlns:D="DAV:" xmlns:e="urn:schemas:httpmail:">
        <D:prop><e:inbox/></D:prop>
        <D:prop><e:calendar/></D:prop>
        <D:prop><e:contacts/></D:prop>
        <D:prop><e:tasks/></D:prop>
        <D:prop><e:notes/></D:prop>
</D:propfind>
END;

    }//end __construct()

}//end class

?>
