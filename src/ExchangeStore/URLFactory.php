<?php
/**
 * URLFactory.php
 *
 * Holds the URLFactory class
 *
 * PHP Version: 5
 *
 * @category File
 * @package  Request
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
 * The URLFactory class is responsible for the generation of the exchange urls
 *
 * PHP Version: 5
 *
 * @category Class
 * @package  Request
 * @author   meza <meza@meza.hu>
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 */
class URLFactory
{
    /**
     * Login type
     */
    const LOGIN = 'login';

    /**
     * Referrer type
     */
    const REFERRER = 'referrer';

    /**
     * User root type
     */
    const USERROOT = 'userroot';

    /**
     * Contact type
     */
    const CONTACT = 'contact';

    /**
     * Calendar type
     */
    const CALENDAR = 'calendar';

    /**
     * @var string The hostname to use in building the urls
     */
    private $_hostname;

    /**
     * @var string The username to use in the urls
     */
    private $_username;

    /**
     * @var URLAccess instance
     */
    private $_urlAccess;


    /**
     * Creates the URLFactory object, and requires data
     *
     * @param string    $hostname  The  hostname of the exchange server
     * @param string    $username  The  username
     * @param URLAccess $urlAccess The urlAccess
     *
     * @return URLFactory
     */
    public function __construct($hostname, $username, $urlAccess)
    {
        $this->_hostname  = $hostname;
        $this->_username  = $username;
        $this->_urlAccess = $urlAccess;

    }//end __construct()


    /**
     * Returns the requested url type.
     *
     * @param string $type   The type of url requested
     * @param mixed  $param1 Extra parameter
     *
     * @return string
     *
     * @throws Exception when an unknown type is requested
     */
    public function getUrlFor($type, $param1=null)
    {
        switch ($type) {
        case self::LOGIN:
            return $this->_getUrlForLogin();
        case self::REFERRER:
            return $this->_hostname.'/exchweb/bin/auth/owalogon.asp';
        case self::USERROOT:
            return $this->_hostname.'/exchange/'.$this->_username.'/';
        case self::CONTACT:
            return $this->_getUrlForContact($param1);
        case self::CALENDAR:
            return $this->_getUrlForCalendar();
        default:
            return $type;
        }

    }//end getUrlFor()


    /**
     * Creates the login url scheme
     *
     * @return string
     */
    private function _getUrlForLogin()
    {
        return $this->_hostname.'/exchweb/bin/auth/owaauth.dll';

    }//end _getUrlForLogin()


    /**
     * Creates the url for a specified contact
     *
     * @param string $contactStorageName The store name of the contact
     *
     * @return string
     */
    private function _getUrlForContact($contactStorageName=null)
    {

        $contact = $this->_urlAccess->contacts;
        $url     = $this->_hostname.'exchange/';
        $url    .= $this->_username.'/'.$contact.'/';
        if (null !==$contactStorageName) {
            $url .=$contactStorageName.'.eml';
        }
        return $url;

    }//end _getUrlForContact()


    /**
     * Creates the url for the calendar store
     *
     * @return string
     */
    private function _getUrlForCalendar()
    {

        $calendar = $this->_urlAccess->calendar;
        $url     = $this->_hostname.'exchange/';
        $url    .= $this->_username.'/'.$calendar.'/';

        return $url;

    }//end _getUrlForCalendar()


}//end class

?>
