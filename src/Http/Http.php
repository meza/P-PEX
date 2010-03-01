<?php
/**
 * Http.php
 *
 * Holds the http comm layer
 *
 * PHP Version: 5
 *
 * @category File
 * @package  Http
 *
 * @author   meza <meza@meza.hu>
 * @license  GPL3.0
 *                    GNU GENERAL PUBLIC LICENSE
 *                       Version 3, 29 June 2007
 *
 * Copyright (C) 2007 Free Software Foundation, Inc. <http://fsf.org/>
 * Everyone is permitted to copy and distribute verbatim copies
 * of this license document, but changing it is not allowed.
 *
 * @version  GIT: $Id$
 * @link     http://www.assembla.com/spaces/p-pex
 **/

/**
 * The Http class is responsible for Curl based Http requests
 *
 * PHP Version: 5
 *
 * @category Class
 * @package  Http
 * @author   meza <meza@meza.hu>
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 */
class Http
{
    const POST = 1;
    const GET  = 0;

    /**
     * @var Curl object
     */
    private $_curl;

    /**
     * @var array the headers
     */
    private $_headers = array();


    /**
     * Csontructs the object
     *
     * @param Curl $curl The curl object to use
     *
     * @return Http
     */
    public function __construct(Curl $curl)
    {
        $this->_curl = $curl;

    }//end __construct()


    /**
     * Returns the internal Curlobject
     *
     * @return Curl
     */
    public function returnCurl()
    {
        return $this->_curl;

    }//end returnCurl()


    /**
     * set's the http method
     *
     * @param string $method The http method to use besides GET/POST
     *
     * @return void
     */
    public function setMethod($method)
    {
        $this->_curl->setMethod($method);

    }//end setMethod()


    /**
     * Add a header to the next request
     * The set headers are reset after the request
     *
     * @param string $key   The header's key
     * @param string $value The header's value
     *
     * @return void
     */
    public function addHeader($key, $value)
    {
        $this->_headers[] = $key.':'.(string) $value;

    }//end addHeader()


    /**
     * Resets the headers
     *
     * @return void
     */
    public function resetHeaders()
    {
        $this->_headers = array();

    }//end resetHeaders()


    /**
     * Makes a http call
     *
     * @param string $url    The url tp call
     * @param array  $data   The data to send
     * @param int    $method Http::POST or Http::GET
     *
     * @return array of return parameters
     */
    public function request($url, $data, $method=self::POST)
    {
        $this->_curl->setDefaults();
        $this->_curl->setHeaders($this->_headers);
        $response = $this->_curl->call($url, $data, (bool) $method);
        $this->resetHeaders();
        return $response;

    }//end request()


}//end class

?>