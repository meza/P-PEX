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
 * 
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
     * Constant of the Contact create parser
     */
    const CONTACT_CREATE = 2;

    /**
     * Constant of the Contact get parsers
     */
    const CONTACT_GET = 3;

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
        case self::CONTACT_CREATE:
            return $this->_createContactCreateParser();
        case self::CONTACT_GET:
            return $this->_createContactGetParser();

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


    private function _createContactCreateParser()
    {
        include_once dirname(__FILE__).'/ContactCreateParser.php';
        $parser = new ContactCreateParser();
        return $parser;

    }//end _createContactCreateParser()


    private function _createContactGetParser()
    {
        include_once dirname(__FILE__).'/ContactGetParser.php';
        $parser = new ContactGetParser();
        return $parser;

    }//end _createContactGetParser()


}//end class

?>
