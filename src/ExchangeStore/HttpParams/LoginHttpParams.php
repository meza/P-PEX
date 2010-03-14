<?php
/**
 * LoginHttpParams.php
 *
 * Holds the LoginHttpParams class
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
 * The LoginHttpParams class is responsible for ...
 *
 * PHP Version: 5
 *
 * @category Class
 * @package  
 * @author   meza
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 */
class LoginHttpParams extends HttpParams
{
    public $url     = URLFactory::LOGIN;
    public $headers = array(
        'Content-Type' => 'application/x-www-form-urlencoded'
    );

    public $referrer   = URLFactory::REFERRER;
    public $httpMethod = 'post';


    /**
     * Creates a login param object
     *
     * @param string $username
     * @param string $password
     * @param string $server
     */
    public function __construct($username, $password, $server)
    {
        $this->httpUsername = $username;
        $this->httpPassword = $password;
        $this->data         = array(
                               'destination' => $server.'/Exchange/'.$username,
                               'username'    => $username,
                               'password'    => $password,
                               'trusted'     => '4',
                               'flags'       => '4'
                              );

    }//end __construct()


}//end class

?>
