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
            'Depth'        => 1,
            'Translate'    => 'f',
        );

    public $httpMethod = 'post';

    public $customMethod = 'search';

    /**
     * Creates a login param object
     *
     * @param string $username
     */
    public function __construct($username)
    {
        $this->data         = <<<END
        <?xml version="1.0"?>
        <D:searchrequest xmlns:D = "DAV:">
           <D:sql>
           SELECT "DAV:contentclass","DAV:displayname"
           FROM SCOPE('hierarchical traversal of "/exchange/$username/"')
           </D:sql>
        </D:searchrequest>
END;


    }//end __construct()

}//end class

?>
