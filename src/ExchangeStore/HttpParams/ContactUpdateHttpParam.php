<?php
/**
 * ContactUpdateHttpParam.php
 *
 * Holds the ContactUpdateHttpParams class
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
 * @link     http://www.assembla.com/spaces/p-pex
 */

/**
 * The ContactUpdateHttpParam class is the value object for contact update
 *
 * PHP Version: 5
 *
 * @category Class
 * @package  ExchangeStore
 * @author   meza <meza@meza.hu>
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 */
class ContactUpdateHttpParam extends ContactCreateHttpParam
{

    /**
     * Creates a login param object
     *
     * @param string $contact The name of the contact
     *
     * @return ContactCreateHttpParam
     */
    public function __construct($url, Contact $contact)
    {
        $this->url  = $url;
        $this->data = '<?xml version="1.0"?>
<g:propertyupdate xmlns:g="DAV:" xmlns:c="urn:schemas:contacts:"
xmlns:e="http://schemas.microsoft.com/exchange/"
xmlns:mapi="http://schemas.microsoft.com/mapi/" xmlns:x="xml:"
xmlns:cal="urn:schemas:calendar:" xmlns:mail="urn:shemas:httpmail:">
<g:set>
    <g:prop>
        <g:contentclass>urn:content-classes:person</g:contentclass>
        <e:outlookmessageclass>IPM.Contact</e:outlookmessageclass>
        <c:givenName>'.$contact->firstName.'</c:givenName>
        <c:middlename>'.$contact->middleName.'</c:middlename>
        <c:sn>'.$contact->lastName.'</c:sn>
        <c:nickname>'.$contact->nickName.'</c:nickname>
        <mapi:email1addrtype>SMTP</mapi:email1addrtype>
        <mapi:email1emailaddress>'.$contact->emailAddress.'</mapi:email1emailaddress>
    </g:prop>
</g:set>
</g:propertyupdate>
';

    }//end __construct()


}//end class

?>
