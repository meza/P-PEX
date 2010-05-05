<?php
/**
 * NoSuchConfigFileException.php
 *
 * Holds the NoSuchConfigFileException class
 *
 * PHP Version: 5
 *
 * @category File
 * @package  Pex
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
 * The NoSuchConfigFileException fires, when a config file is not found
 *
 * PHP Version: 5
 *
 * @category Class
 * @package  Pex
 * @author   meza <meza@meza.hu>
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 */
class NoSuchConfigFileException extends Exception
{


    /**
     * Creates the Exception by setting the message
     *
     * @param string $configFile The requested file
     *
     * @return NoSuchConfigFileException
     */
    public function  __construct($configFile)
    {
        $this->message = 'Config file not found: "'.realpath($configFile).'"';

    }//end __construct()


}//end class

?>
