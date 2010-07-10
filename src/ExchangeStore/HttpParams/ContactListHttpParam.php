<?php
/**
 * ContactListHttpParam.php
 *
 * Holds the ContactListHttpParam class
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
 * The ContactListHttpParam class is the value object for contact data retrieval
 *
 * PHP Version: 5
 *
 * @category Class
 * @package  ExchangeStore
 * @author   meza <meza@meza.hu>
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 */
class ContactListHttpParam extends HttpParams
{

    /**
     * @var string The root url
     */
    public $url = ExchangeStoreURLFactory::CONTACT;

    /**
     * @var array The headers to use for the request
     */
    public $headers = array(
                       'Content-Type' => 'text/xml',
                       'Depth'        => 1,
                       'Translate'    => 'f',
                      );

    /**
     * @var string The http method to use
     */
    public $httpMethod = 'post';

    /**
     * @var string The custom http method to use
     */
    public $customMethod = 'search';


    /**
     * Creates a login param object
     *
     * @return ContactListHttpParam
     */
    public function __construct()
    {
        $this->data = '<?xml version="1.0"?>
<a:searchrequest
xmlns:a="DAV:"
xmlns:c="urn:schemas:contacts:"
xmlns:e="http://schemas.microsoft.com/exchange/"
xmlns:mapi="http://schemas.microsoft.com/mapi/"
xmlns:x="xml:"
xmlns:cal="urn:schemas:calendar:"
xmlns:mail="urn:shemas:httpmail:">
<a:sql>SELECT
"DAV:href",
"urn:schemas:contacts:givenName",
"urn:schemas:contacts:middlename",
"urn:schemas:contacts:sn",
"urn:schemas:contacts:fileas",
"urn:schemas:contacts:nickname",
"http://schemas.microsoft.com/mapi/email1emailaddress"
FROM "'.$this->preparedUrl.'"
</a:sql>
</a:searchrequest>';

    }//end __construct()

}//end class

?>
