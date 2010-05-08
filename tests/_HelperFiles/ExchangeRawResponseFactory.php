<?php
/**
 * ExchangeRawResponseFactory.php
 *
 * Holds the ExchangeRawResponseFactory class
 *
 * PHP Version: 5
 *
 * @category File
 * @package  Testhelper
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
 * The ExchangeRawResponseFactory class is responsible for returning xyml msgs
 *
 * PHP Version: 5
 *
 * @category Class
 * @package  Testhelper
 * @author   meza
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 */
class ExchangeRawResponseFactory
{

    public function getSuccessfulContactCreationResponse(
        $url='https://server.com/exchange/user/Contacts/test.eml'
    ) {
        return '<?xml version="1.0"?>
<a:multistatus xmlns:d="http://schemas.microsoft.com/mapi/"
xmlns:b="http://schemas.microsoft.com/exchange/" xmlns:c="urn:schemas:contacts:"
xmlns:a="DAV:">
<a:response>
<a:href>'.$url.'</a:href>
<a:propstat><a:status>HTTP/1.1 200 OK</a:status>
<a:prop><a:contentclass/><b:outlookmessageclass/><c:givenName/><c:middlename/>
<c:sn/><c:fileas/><c:nickname/><d:email1addrtype/><d:email1emailaddress/>
</a:prop></a:propstat></a:response></a:multistatus>';
    }


    public function getContactResponse(
        $url='https://server.com/exchange/user/Contacts/Test%20User.eml'
    ) {
        return '<?xml version="1.0"?>
<a:multistatus xmlns:b="urn:uuid:c2f41010-65b3-11d1-a29f-00aa00c14882/"
xmlns:e="urn:schemas:httpmail:" xmlns:i="urn:schemas:mailheader:"
xmlns:c="xml:" xmlns:f="http://schemas.microsoft.com/exchange/"
xmlns:h="urn:schemas-microsoft-com:office:office"
xmlns:j="http://schemas.microsoft.com/repl/" xmlns:g="urn:schemas:calendar:"
xmlns:d="urn:schemas:contacts:" xmlns:k="urn:schemas-microsoft-com:exch-data:"
xmlns:a="DAV:"><a:response><a:href>'.$url.'</a:href><a:propstat>
<a:status>HTTP/1.1 200 OK</a:status><a:prop><d:initials>T.U.</d:initials>
<a:contentclass>urn:content-classes:person</a:contentclass><d:workaddress>
</d:workaddress><a:supportedlock><lockentry xmlns="DAV:"><locktype>
<transaction><groupoperation/></transaction></locktype><lockscope>
<local/></lockscope></lockentry></a:supportedlock><d:sn>Test</d:sn>
<d:fileas>Test User</d:fileas><d:homepostaladdress></d:homepostaladdress>
<d:givenName>User</d:givenName><f:permanenturl>
https://server.com/exchange/user/-FlatUrlSpace-/0e7862d196d29e4994f316b9760a8a21-1491eb/0e7862d196d29e4994f316b9760a8a21-16a055</f:permanenturl>
<a:getcontenttype>message/rfc822</a:getcontenttype>
<a:id>AQEAAAAAFJHrAQAAAAAWoFUAAAAA</a:id>
<f:mid b:dt="i8">6169955678753390593</f:mid><d:middlename></d:middlename>
<a:isfolder b:dt="boolean">0</a:isfolder><a:resourcetype/>
<a:getetag>"0e7862d196d29e4994f316b9760a8a21000000170b2b"</a:getetag>
<d:fileasid b:dt="int">0</d:fileasid><lockdiscovery xmlns="DAV:">
</lockdiscovery><d:email1>&lt;test@domain.com&gt;</d:email1>
<f:outlookmessageclass>IPM.Contact</f:outlookmessageclass>
<a:creationdate b:dt="dateTime.tz">2010-05-08T12:10:08.915Z</a:creationdate>
<f:ntsecuritydescriptor b:dt="bin.base64">CAAEAAAAAAABAC+MMAAAAEwAAAAAAAAAFAAAAAIAHAABAAAAARAUAL8PHwABAQAAAAAABQcAAAABBQAAAAAABRUAAAB7ip+Xnx/HM6YKnQeVBAAAAQIAAAAAAAUgAAAAIAIAAA==</f:ntsecuritydescriptor>
<a:ishidden b:dt="boolean">0</a:ishidden>
<d:proxyaddresses b:dt="mv.string"><c:v>&lt;test@domain.com&gt;</c:v>
</d:proxyaddresses><a:parentname>https://server.com/exchange/user/Contacts/</a:parentname>
<d:nickname>tuser</d:nickname><a:getcontentlength b:dt="int">254</a:getcontentlength>
<a:isstructureddocument b:dt="boolean">0</a:isstructureddocument>
<j:repl-uid>rid:0e7862d196d29e4994f316b9760a8a2100000016a055</j:repl-uid>
<a:displayname>Test++User.eml</a:displayname><a:href>'.$url.'</a:href>
<a:isreadonly b:dt="boolean">0</a:isreadonly>
<a:uid>AQEAAAAAFqBVAAAAAAAAAAAAAAAA</a:uid>
<a:getlastmodified b:dt="dateTime.tz">2010-05-08T13:23:58.513Z</a:getlastmodified>
<e:hasattachment b:dt="boolean">0</e:hasattachment>
<a:iscollection b:dt="boolean">0</a:iscollection><d:cn>User Test</d:cn>
<e:read b:dt="boolean">1</e:read>
<j:resourcetag>rt:0e7862d196d29e4994f316b9760a8a2100000016a0550e7862d196d29e4994f316b9760a8a21000000170b2b</j:resourcetag>
<d:otherpostaladdress></d:otherpostaladdress></a:prop></a:propstat></a:response>
</a:multistatus>';
    }

}//end class

?>
