<?php
/**
 * CurlBuilder.php
 *
 * Holds the CurlBuilder class
 *
 * PHP Version: 5
 *
 * @category File
 * @package  Http
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

require_once dirname(__FILE__).'/Curl.php';
require_once dirname(__FILE__).'/Exceptions/InvalidHttpMethodException.php';
require_once dirname(__FILE__).'/Exceptions/NoUrlSetException.php';

/**
 * The CurlBuilder class is responsible for building specific curl instances
 *
 * PHP Version: 5
 *
 * @category Class
 * @package  Http
 * @author   meza
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 */
class CurlBuilder
{

    /**
     * Creates a curl instance from the given arguments
     *
     * @param HttpParams $httpParams The Http config object
     * @param array      $config     Extra config parameters
     *
     * @return Curl
     */
    public function createCurl(HttpParams $httpParams, array $config=array())
    {
        $curl = new Curl();
        $curl->setReturnTransfer(true);
        $curl->verbose(false);
        $curl->returnHeaders(false);
        
        $this->_applyConfig($curl, $config);

        $headers   = $this->_parseHeaders($httpParams->headers);
        $headers[] = 'User-Agent: '.$httpParams->userAgent;
        $curl->setHeaders($headers);

        if (null !== $httpParams->data) {
            $curl->setData($httpParams->data);
        }

        $httpMethod = $this->_parseHttpMethod($httpParams->httpMethod);
        if ('POST' === $httpMethod) {
            $curl->setPost(true);
        }

        if (null !== $httpParams->referrer) {
            $curl->setReferrer($httpParams->referrer);
        }

        if (null === $httpParams->url) {
            throw new NoUrlSetException();
        }

        $curl->setUrl($httpParams->url);

        if (null !== $httpParams->customMethod) {
            $curl->setCustomMethod(strtoupper($httpParams->customMethod));
        }

        if (
                (null !== $httpParams->httpUsername)
                && (null !== $httpParams->httpPassword)
        ) {
            $curl->setAuth(
                    $httpParams->httpUsername,
                    $httpParams->httpPassword,
                    CURLAUTH_BASIC
            );
        }

        return $curl;

    }//end createCurl()


    /**
     * Applies extra config
     *
     * @param Curl  $curl   The curl instance to work with
     * @param array $config The extra config array
     *
     * @return void
     */
    private function _applyConfig(Curl $curl, array $config=array())
    {
        if (true === isset($config['cookieStore'])) {
            $curl->setCookieStore($config['cookieStore']);
        }

        if (true === isset($config['followLocation'])) {
            $curl->followLocation($config['follwLocation']);
        }

        if (true === isset($config['SSLVerifyHost'])) {
            $curl->setSSLVerifyHost($config['SSLVerifyHost']);
        }

        if (true === isset($config['SSLVerifyPeer'])) {
            $curl->setSSLVerifyPeer($config['SSLVerifyPeer']);
        }

        if (true === isset($config['verbose'])) {
            $curl->verbose($config['verbose']);
        }

        if (true === isset($config['returnTransfer'])) {
            $curl->verbose($config['returnTransfer']);
        }

    }//end _applyConfig()


    /**
     * Parses the httpMethod variable. It could only be POST or GET
     *
     * @param string $method The given Http method to use
     *
     * @return string uppercased method if valid
     *
     * @throws InvalidHttpMethodException when needed
     */
    private function _parseHttpMethod($method)
    {
        $validMethods = array(
            'GET',
            'POST',
        );

        $method = strtoupper($method);

        if (false === in_array($method, $validMethods))
        {
            throw new InvalidHttpMethodException();
        }

        return $method;

    }//end _parseHttpMethod()


    /**
     * Parses the header data
     * 
     * @param array $headers An associative array of headers, where the array
     * keys could be the header names. If the array key is numeric, than the
     * value is added to the headers array. If it is a string, than it is added
     * as $key: $value to the headers array
     * 
     * @return array of parsed headers
     */
    private function _parseHeaders(array $headers)
    {
        $retval = array();
        foreach ($headers as $key=>$value)
        {
            if (true === is_numeric($key)) {
                $retval[] = $value;
            } elseif (true === is_string($key)) {
                $retval[] = $key.': '.$value;
            }

        }
        
        return $retval;

    }//end _parseHeaders()


}//end class

?>
