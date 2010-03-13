<?php
/**
 * Request.php
 *
 * Holds the Request interface
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
 * The Request interface defines request object's usage
 *
 * PHP Version: 5
 *
 * @category Interface
 * @package  Request
 * @author   meza <meza@meza.hu>
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 */
interface Request
{

    public function getHeaders();
    public function getData();
    public function getMethod();
    
}//end interface

?>
