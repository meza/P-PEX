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
     * Holds the url, where the login should go
     */
    const LOGONURL = 'exchweb/bin/auth/owaauth.dll';

    /**
     * The Inbox's name
     */
    const INBOX    = 'Inbox';

    /**
     * @var string The hostname to use in building the urls
     */
    private $_hostname;

    /**
     * @var string The username to use in the urls
     */
    private $_username;
    
    public function __construct($hostname, $username)
    {
        
    }//end __construct()


}//end class

?>
