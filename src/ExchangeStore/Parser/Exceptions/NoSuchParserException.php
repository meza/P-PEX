<?php
/**
 * NoSuchParserException.php
 *
 * Holds the NoSuchParserException class
 *
 * PHP Version: 5
 *
 * @category File
 * @package  Parser
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
//namespace Pex\ExchangeStore\Parser\Exceptions;
namespace Pex;
/**
 * The NoSuchParserException fires, when an unexisting Parser was called
 *
 * PHP Version: 5
 *
 * @category Class
 * @package  Parser
 * @author   meza <meza@meza.hu>
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 */
class NoSuchParserException extends Exception
{


    /**
     * Creates the Exception by setting the message
     *
     * @param string $parser The requested Parser
     *
     * @return InvalidCustomHttpMethodException
     */
    public function  __construct($parser)
    {
        $this->message = 'No such parser as: "'.$parser.'"';

    }//end __construct()


}//end class

?>
