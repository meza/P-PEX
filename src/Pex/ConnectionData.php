<?php
/**
 * ConnectionData.php
 *
 * Holds the connection data value object
 *
 * PHP version: 5.2
 *
 * @category File
 * @package  Pex
 *
 * @author   meza <meza@meza.hu>
 * @license  GPL3.0
 *                    GNU GENERAL PUBLIC LICENSE
 *                       Version 3, 29 June 2007
 *
 * Copyright (C) 2007 Free Software Foundation, Inc. <http://fsf.org/>
 * Everyone is permitted to copy and distribute verbatim copies
 * of this license document, but changing it is not allowed.
 * @version  GIT: $ID$
 * @link     http://www.assembla.com/spaces/p-pex
 */

/**
 * The value object of the connection data
 *
 * @category Class
 * @package  Pex
 *
 * @author   meza <meza@meza.hu>
 *
 * @property uAgent   The user agent to use
 * @property host     The server's host
 * @property username The username
 * @property password The password
 *
 * @license  GPL3.0
 *                    GNU GENERAL PUBLIC LICENSE
 *                       Version 3, 29 June 2007
 *
 * Copyright (C) 2007 Free Software Foundation, Inc. <http://fsf.org/>
 * Everyone is permitted to copy and distribute verbatim copies
 * of this license document, but changing it is not allowed.
 * @link     http://www.assembla.com/spaces/p-pex
 */
class ConnectionData
{

    /**
     * @var string The user agent string to use
     */
    public $uAgent = "User-Agent: Mozilla/5.0 (X11; U; Linux x86_64; hu-HU; rv:1.9.1.8) Gecko/20100214 Ubuntu/9.10 (karmic) Firefox/3.5.8";

    /**
     * @var string The host of the exchange server
     */
    public $host;

    /**
     * @var string The username of the user
     */
    public $username;

    /**
     * @var string The password of the user
     */
    public $password;

}//end class

?>
