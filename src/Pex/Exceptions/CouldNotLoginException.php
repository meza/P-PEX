<?php
/**
 * CouldNotLoginException.php
 *
 * Holds the CouldNotLoginException class
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
//namespace Pex\Exceptions;
namespace Pex;
/**
 * The CouldNotLoginException fires, when a numerous login was unsuccessful
 *
 * PHP Version: 5
 *
 * @category Class
 * @package  Pex
 * @author   meza <meza@meza.hu>
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 */
class CouldNotLoginException extends \Exception
{


    /**
     * Creates the Exception by setting the message
     *
     * @return CouldNotLoginException
     */
    public function  __construct()
    {
        $this->message = 'Could not login';

    }//end __construct()


}//end class

?>
