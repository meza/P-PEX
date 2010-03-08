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
     * @var string The filename of the cookieStore (if set)
     */
    private $cookieStore=null;

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

        //we set a couple of default VALUEs

        $this->_curl->setReturnTransfer(true);
        $this->followLocation(false);
        $this->verifySSL(false);
        $this->returnHeaders(false);


    }//end __construct()


    /**
     * Returns the internal Curlobject
	 *
	 * @deprecated
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
     * Sets the cookie store of the curl
     *
     * @param string $cookieFile The filename to use as a cookie store
     *
     * @return void
     */
    public function setCookieStore($cookieFile='cookies.txt')
    {
        $this->cookieStore = $cookieFile;
        $this->_curl->setCookieStore($this->cookieStore);
        
    }//end setCookieStore()


    /**
     * Sets SSL verification policy
     *
     * @param bool $flag True to verify ssl certs, false to not
     *
     * @return void
     */
    public function verifySSL($flag=false)
    {
        $this->_curl->setSSLVerifyHost($flag);
        $this->_curl->setSSLVerifyPeer($flag);

    }//end verifySSL()


    /**
     * Sets wether the request should follow redirects
     *
     * @param bool $flag True to follow, false to not
     *
     * @return void
     */
    public function followLocation($flag=true)
    {
        $this->_curl->followLocation($flag);

    }//end followLocation()


    /**
     * If set to true, the response headers will be the part of the response
     * string
     *
     * @param bool $flag True to return headers, false to not
     *
     * @return void
     */
    public function returnHeaders($flag=false)
    {
        $this->_curl->returnHeaders($flag);

    }//end returnHeaders()

    
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
        $this->_curl->setHeaders($this->_headers);
        $response = $this->_curl->call($url, $data, (bool) $method);
        $this->resetHeaders();
        return $response;

    }//end request()


}//end class

?>