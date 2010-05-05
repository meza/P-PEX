<?php
/**
 * NoSuchConfigSectionException.php
 *
 * Holds the NoSuchConfigSectionException class
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
 * The NoSuchConfigSectionException fires, when a config section is not found
 *
 * PHP Version: 5
 *
 * @category Class
 * @package  Pex
 * @author   meza <meza@meza.hu>
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 */
class NoSuchConfigSectionException extends Exception
{


    /**
     * Creates the Exception by setting the message
     *
     * @param string $section The requested section
     *
     * @return NoSuchConfigSectionException
     */
    public function  __construct($section)
    {
        $this->message = 'Config file section not found: "'.$section.'"';

    }//end __construct()


}//end class

?>
