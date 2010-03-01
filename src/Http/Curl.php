<?php
/**
 * Curl.php
 *
 * Holds the Curl class
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
 * @version  SVN: $Id$
 * @link     http://www.assembla.com/spaces/p-pex
 **/

/**
 * The Curl class is responsible for Http requests
 *
 * PHP Version: 5
 *
 * @category Class
 * @package  Http
 * @author   meza <meza@meza.hu>
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 */
class Curl
{

    /**
     * @var resource CurlHandler
     */
    private $_ch;


    /**
     * Constructs the object
     *
     * @return Curl
     */
    public function __construct()
    {
        $this->_ch = curl_init();

    }//end __construct()


    /**
     * Set's the default options
     *
     * @return void
     */
    public function setDefaults()
    {
            $this->followLocation(true);
            $this->returnHeaders(false);
            $this->setCookieStore('cookies.txt');
            $this->setReturnTransfer(true);
            $this->setSSLVerifyHost(false);
            $this->setSSLVerifyPeer(false);
            $this->verbose(false);

    }//end setDefaults()


    /**
     * Sets cUrl's verbosity to $flag
     *
     * @param bool $flag true to be verbose, false to not
     *
     * @return void
     */
    public function verbose($flag=false)
    {
            curl_setopt($this->_ch, CURLOPT_VERBOSE, $flag);

    }//end verbose()


    /**
     * Set's cUrl's followLocation flag to $flag
     *
     * @param bool $flag true to follow location, false to not
     *
     * @return void
     */
    public function followLocation($flag=true)
    {
            curl_setopt($this->_ch, CURLOPT_FOLLOWLOCATION, $flag);

    }//end followLocation()


    /**
     * Sets the file to use as a cookiejar.
     * The filename specified must be writable by the php's user.
     *
     * @param string $filename The filename to use
     *
     * @return void
     *
     * @throws Exception if the cookiefile is not writable
     */
    public function setCookieStore($filename)
    {
        if (false === is_writable(dirname($filename))) {
            throw new Exception('Cookie store\'s directory is not writable');
        }

        curl_setopt($this->_ch, CURLOPT_COOKIEJAR, $filename);
        curl_setopt($this->_ch, CURLOPT_COOKIEFILE, $filename);

    }//end setCookieStore()


    /**
     * Set the referrer of the request;
     *
     * @param string $value The referrer url to use
     * 
     * @return void
     */
    public function setReferrer($value=null)
    {
            curl_setopt($this->_ch, CURLOPT_REFERER, $value);

    }//end setReferrer()


    /**
     * Set's a custom method to use for the request.
     * The base GET/POST should be set to define the behaviour of the custom
     * call.
     *
     * @param string $method The http method to use. The argument is converted
     * to uppercase!
     *
     * @return void
     *
     * @throws Exception if GET/POST is used
     */
    public function setMethod($method)
    {
        $standardMethods = array(
                            'GET',
                            'POST',
                           );
        if (true === in_array(strtoupper($method), $standardMethods)) {
                throw new Exception(
                    $method.' is a standard method, don\'t use as custom'
                );
        } else {
                curl_setopt($this->_ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));
        }

    }//end setMethod()


    /**
     * Sets if the response headers should be included in the response string
     * or not
     *
     * @param bool $flag True to include, false to not
     *
     * @return void
     */
    public function returnHeaders($flag=false)
    {
            curl_setopt($this->_ch, CURLOPT_HEADER, (int) $flag);

    }//end returnHeaders()


    /**
     * Sets the authentication credentials
     *
     * @param string $user The username
     * @param string $pass The password
     * @param int    $type The type of auth
     * CURLAUTH_BASIC,CURLAUTH_DIGEST,CURLAUTH_GSSNEGOTIATE,CURLAUTH_NTLM,
     * CURLAUTH_ANY,CURLAUTH_ANYSAFE
     *
     * @return void
     */
    public function setAuth($user, $pass, $type=CURLAUTH_ANY)
    {
            curl_setopt($this->_ch, CURLOPT_HTTPAUTH, $type);
            curl_setopt($this->_ch, CURLOPT_USERPWD, $user.':'.$pass);

    }//end setAuth()


    /**
     * Sets the headers
     *
     * @param array $headers The array of headers to set
     *
     * @return void
     */
    public function setHeaders(array $headers)
    {
        curl_setopt($this->_ch, CURLOPT_HTTPHEADER, $headers);

    }//end setHeaders()


    /**
     * Get information regarding the transfer
     *
     * @param string $part The data part
     *
     * @return mixed
     *
     * @see http://php.net/manual/en/function.curl-getinfo.php
     */
    public function getInfo($part=null)
    {
        if (null === $part) {
            return curl_getinfo($this->_ch);
        }

        return curl_getinfo($this->_ch, $part);

    }//end getInfo()


    /**
     * Sets the url
     *
     * @param string $url The url to use
     *
     * @return void
     */
    public function setUrl($url)
    {
        curl_setopt($this->_ch, CURLOPT_URL, $url);

    }//end setUrl()


    /**
     * Sets the ssl_verifypeer flag to $flag
     *
     * @param boolean $flag True or False
     *
     * @return void
     */
    public function setSSLVerifyPeer($flag=false)
    {
        curl_setopt($this->_ch, CURLOPT_SSL_VERIFYPEER, $flag);

    }//end setSSLVerifyPeer()


    /**
     * Sets the ssl_verifyhost flag to $flag
     *
     * @param boolean $flag True or False
     *
     * @return void
     */
    public function setSSLVerifyHost($flag=false)
    {
        curl_setopt($this->_ch, CURLOPT_SSL_VERIFYHOST, $flag);

    }//end setSSLVerifyHost()


    /**
     * Sets the return transfer flag to $flag
     *
     * @param boolean $flag True or False
     *
     * @return void
     */
    public function setReturnTransfer($flag=true)
    {
        curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, $flag);

    }//end setReturnTransfer()


    /**
     * Sets the post flag to $flag
     *
     * @param boolean $flag True or False
     *
     * @return void
     */
    public function setPost($flag=true)
    {
        curl_setopt($this->_ch, CURLOPT_POST, (int) $flag);

    }//end setPost()


    /**
     * Formats the given value to a query string
     * 
     * @param mixed $data String, object, array -> query string
     * 
     * @return void
     */
    private function _formatData($data)
    {
        if (true === is_array($data)) {
            $data = http_build_query($data);
        } else if (true === is_object($data)) {
            $data = http_build_query(get_object_vars($data));
        }

        return $data;

    }//end _formatData()


    /**
     * Sets the post fields parameter
     *
     * @param mixed $data Either a query string, or an array.
     *
     * @return void
     */
    public function setPostFields($data)
    {
        curl_setopt(
            $this->_ch,
            CURLOPT_POSTFIELDS,
            $this->_formatData($data)
        );

    }//end setPostFields()


    /**
     * Executes a Curl call
     *
     * @param string $url  The url to call to (optional)
     * @param mixed  $data The data to be sent by the request (optional)
     * @param bool   $post The call is POST or not (optional)
     *
     * @return string The return string
     */
    public function call($url=null, $data='', $post=false)
    {
        if (null !== $url) {
            $this->setUrl($url);
        }

        $url = curl_getinfo($this->_ch, CURLINFO_EFFECTIVE_URL);
        if (true === (bool) $post) {
            $this->setPost(1);
            $this->setPostFields($data);
        } else {
            if (false === empty($data)) {
                $this->setUrl($url.'?'.$this->_formatData($data));
            }
        }

        return $this->_execute();

    }//end call()


    /**
     * Executes the call
     *
     * @return string result
     *
     * @throws Exception on error
     */
    private function _execute()
    {
        $retval = curl_exec($this->_ch);
        $errno  = curl_errno($this->_ch);
        if ((int) 0 < $errno) {
            $errstr = curl_error($this->_ch);
            throw new Exception($errstr, $errno);
        }

        return $retval;

    }//end _execute()


}//end class

?>
