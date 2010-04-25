<?php
/**
 * ParserFactory.php
 *
 * Holds the ParserFactory class
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
 * The ParserFactory class is responsible for the generation of the Parser
 * implementations
 *
 * PHP Version: 5
 *
 * @category Class
 * @package  Parser
 * @author   meza <meza@meza.hu>
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 */
class ParserFactory
{

    /**
     * Constant of the Store URL parser
     */
    const STORE_URLS = 1;


    /**
     * Creates the required Parser implementation
     *
     * @param int $type The type to create
     *
     * @return Parser implementation
     *
     * @throws NoSuchParserException when the requested Parser is unknown
     */
    public function createParser($type)
    {
        switch($type) {
        case self::STORE_URLS:
            return $this->_createStoreUrlParser();

        default:
            throw new NoSuchParserException($type);
        }

    }//end createParser()


    /**
     * Creates an instance of StoreUrlParser
     *
     * @return StoreUrlParser
     */
    private function _createStoreUrlParser()
    {
        include_once dirname(__FILE__).'/StoreUrlParser.php';
        $parser = new StoreUrlParser();
        return $parser;

    }//end _createStoreUrlParser()


}//end class

?>
