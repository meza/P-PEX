<?php
/**
 * ContactCreateHttpParams.php
 *
 * Holds the ContactCreateHttpParams class
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
 * * 
 * @version  GIT: $Id$
 * @link     http://www.assembla.com/spaces/p-pex
 */

/**
 * The ContactCreateHttpParams class is the value object for contact creation
 *
 * PHP Version: 5
 *
 * @category Class
 * @package  ExchangeStore
 * @author   meza <meza@meza.hu>
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 */
class ContactCreateHttpParams extends HttpParams
{

    /**
     * @var string The root url
     */
    public $url = URLFactory::CONTACT;

    /**
     * @var array The headers to use for the request
     */
    public $headers = array(
                       'Content-Type' => 'text/xml',
//                       'Depth'        => 0,
                       'Translate'    => 'f',
                      );

    /**
     * @var string The http method to use
     */
    public $httpMethod = 'post';

    /**
     * @var string The custom http method to use
     */
    public $customMethod = 'PROPPATCH';


    /**
     * Creates a login param object
     *
     * @return ContactCreateHttpParams
     */
    public function __construct($name)
    {

        $this->urlParams = array(
            $this->prepareName($name),
        );

        $this->data = '<?xml version="1.0"?>
<g:propertyupdate xmlns:g="DAV:" xmlns:c="urn:schemas:contacts:"
xmlns:e="http://schemas.microsoft.com/exchange/"
xmlns:mapi="http://schemas.microsoft.com/mapi/" xmlns:x="xml:"
xmlns:cal="urn:schemas:calendar:" xmlns:mail="urn:shemas:httpmail:">
<g:set>
    <g:prop>
        <g:contentclass>urn:content-classes:person</g:contentclass>
        <e:outlookmessageclass>IPM.Contact</e:outlookmessageclass>
        <c:givenName>JoLynn</c:givenName>
        <c:middlename>Julie</c:middlename>
        <c:sn>Dobney</c:sn>
        <c:cn>JoLynn J. Dobney</c:cn>
        <mail:subject>JoLynn Dobney</mail:subject>
        <c:fileas>Dobney, JoLynn</c:fileas>
        <c:initials>JJD</c:initials>
        <c:nickname>Jo</c:nickname>
        <c:personaltitle>Mrs.</c:personaltitle>
        <c:namesuffix>MCSD</c:namesuffix>
    </g:prop>
</g:set>
</g:propertyupdate>
';

    }//end __construct()

    private function prepareName($name)
    {
        return $name;
    }


}//end class

?>
