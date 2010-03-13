<?php
/**
 * HttpFactory.php
 *
 * Holds the HttpFactory class
 *
 * PHP Version: 5
 *
 * @category File
 * @package  Http
 * @author   meza <meza@meza.hu>
 * 
 * @license  GPL3.0
 *                    GNU GENERAL PUBLIC LICENSE
 *                       Version 3, 29 June 2007
 *
 * Copyright (C) 2007 Free Software Foundation, Inc. <http://fsf.org/>
 * Everyone is permitted to copy and distribute verbatim copies
 * of this license document, but changing it is not allowed.
 *
 * @version  GIT: $Id: e97a355221e6754a2376824270b27b5813cf3df3 $
 * @link     http://www.assembla.com/spaces/p-pex
 */

/**
 * The HttpFactory class is responsible for creating Http objects
 *
 * PHP Version: 5
 *
 * @category Class
 * @package  Http
 * @author   meza <meza@meza.hu>
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 */
class HttpFactory
{

    /**
     * @var CurlBuilder The CurlBuilder instance to use
     */
    private $_curlBuilder;


    /**
     * Constructs the HttpBuilder object, while requiring the dependencies
     *
     * @param CurlBuilder $curlBuilder A CurlBuilder instance to use
     *
     * @return HttpFactory
     */
    public function  __construct(CurlBuilder $curlBuilder)
    {
        $this->_curlBuilder = $curlBuilder;

    }//end __construct()


    /**
     * Creates a pre-configured Http object
     *
     * @return Http
     */
    public function createHttp()
    {
        $http = new Http($this->_curlBuilder);

        $http->followLocation(true);
        $http->verifySSL(false);
        $http->setCookieStore('cookies.txt');

        return $http;

    }//end createHttp()


}//end class

?>
