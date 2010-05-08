<?php
/**
 * ContactGetHttpParams.php
 *
 * Holds the ContactGetHttpParams class
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
 * The ContactGetHttpParams class is the value object for contact data retrieval
 *
 * PHP Version: 5
 *
 * @category Class
 * @package  ExchangeStore
 * @author   meza <meza@meza.hu>
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 */
class ContactGetHttpParams extends HttpParams
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
                       'Depth'        => 0,
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
     * @param string $contact The name of the contact
     *
     * @return ContactGetHttpParams
     */
    public function __construct(Contact $contact, URLFactory $factory)
    {
        $name = $contact->getFileAsName();

        $this->data = '<D:searchrequest xmlns:D = "DAV:" xmlns:d="urn:schemas:contacts:">
   <D:sql>
SELECT *  FROM SCOPE(\'deep traversal of "'.$factory->getUrlFor(URLFactory::CONTACT).'"\')
WHERE "DAV:ishidden" = false AND "DAV:isfolder" = false
AND "urn:schemas:contacts:fileas" = \''.$name.'\'
   </D:sql>
</D:searchrequest>
';

    }//end __construct()


    /**
     * Prepares the name for the url.
     * Performs an urlencode
     *
     * @param string $name The contact's name
     *
     * @return string
     */
    private function _prepareName($name)
    {
        return urlencode($name);

    }//end _prepareName()


}//end class

?>
