<?php
/**
 * Parser.php
 *
 * Holds the Parser interface
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
 * *
 * @version  GIT: $Id$
 * @link     http://www.assembla.com/spaces/p-pex
 */

/**
 * The Parser interface defines the common usage of the parser objects
 *
 * PHP Version: 5
 *
 * @category Interface
 * @package  Parser
 * @author   meza <meza@meza.hu>
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 */
interface Parser
{


    /**
     * Main parser method, that all Parser implementations should implement.
     *
     * @param string $xmlString The response xml string
     *
     * @return ExchangeResponse implementation
     */
    public function parse($xmlString);


}//end interface

?>
