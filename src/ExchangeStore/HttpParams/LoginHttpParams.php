<?php
/**
 * LoginHttpParams.php
 *
 * Holds the LoginHttpParams class
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
 * The LoginHttpParams class is the http param preset for a login call
 *
 * PHP Version: 5
 *
 * @category Class
 * @package  ExchangeStore
 * @author   meza <meza@meza.hu>
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 */
class LoginHttpParams extends HttpParams
{

    /**
     * @var string The Login request needs the specific login url
     */
    public $url = URLFactory::LOGIN;

    /**
     * The default headers for the request
     * @var array
     */
    public $headers = array('Content-Type' => 'application/x-www-form-urlencoded');

    /**
     * @var string The referrer url type
     */
    public $referrer = URLFactory::REFERRER;

    /**
     * @var string The http method to use
     */
    public $httpMethod = 'post';


    /**
     * Creates a login param object
     *
     * @param string $username The exchange username
     * @param string $password The exchange password
     * @param string $server   The exchange server url
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
                               'flags'       => '4',
                              );

    }//end __construct()


}//end class

?>