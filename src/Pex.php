<?php
/**
 * Pex.php
 *
 * Holds the Pex class
 *
 * PHP Version: 5
 *
 * @category File
 * @package  Pex
 *
 * 
 * @author   meza <meza@meza.hu>
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

/**
 * The Pex class is responsible for the main functionality.
 * Should be able to serve all expectations from the exchange server
 *
 * PHP Version: 5
 *
 * @category Class
 * @package  Pex
 * @author   meza <meza@meza.hu>
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 */
class Pex
{

    /**
     * Holds the user agent string of the request
     */
    const USERAGENT = 'Mozilla/5.0 (X11; U; Linux x86_64; hu-HU; rv:1.9.1.8)
                      Gecko/20100214 Ubuntu/9.10 (karmic) Firefox/3.5.8';

    /**
     * @var Http the http layer to use
     */
    private $_http;

    /**
     * @var RequestFactory The factory used to create requests
     */
    private $_requestFactory;

    /**
     * @var string host
     */
    private $_host;

    /**
     * @var string username
     */
    private $_username;

    /**
     * @var string password
     */
    private $_password;


    /**
     * Constructs the object
     *
     * @param Http           $http           The Http object to use as the
     *                                       communication layer
     * @param RequestFactory $requestFactory The factory to use for creating
     *                                       requests
     * @param string         $host           The host to use as an exchange
     *                                       server
     * @param string         $username       The username to use on the host
     * @param string         $password       The password to use on the host
     *
     * @return Pex
     */
    public function __construct(
        Http $http,
        RequestFactory $requestFactory,
        $host,
        $username,
        $password
    ) {
        $this->_host           = $host;
        $this->_requestFactory = $requestFactory;
        $this->_http           = $http;
        $this->_password       = $password;
        $this->_username       = $username;

    }//end __construct()


}//end class

?>