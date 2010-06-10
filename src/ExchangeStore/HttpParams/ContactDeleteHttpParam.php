<?php
/**
 * ContactDeleteHttpParams.php
 *
 * Holds the ContactDeleteHttpParams class
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
 * The ContactDeleteHttpParams class is the value object for contact removal
 *
 * PHP Version: 5
 *
 * @category Class
 * @package  ExchangeStore
 * @author   meza <meza@meza.hu>
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 */
class ContactDeleteHttpParams extends HttpParams
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
                       'Depth'        => 'infinity',
                       'Translate'    => 'f',
                      );

    /**
     * @var string The http method to use
     */
    public $httpMethod = 'post';

    /**
     * @var string The custom http method to use
     */
    public $customMethod = 'DELETE';


    /**
     * Creates a login param object
     *
     * @param string $contact The name of the contact
     *
     * @return ContactDeleteHttpParams
     */
    public function __construct(Contact $contact)
    {
        $this->url = $contact->getUrl();

    }//end __construct()

}//end class

?>
