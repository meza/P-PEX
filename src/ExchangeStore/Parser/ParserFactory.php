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
 //namespace Pex\ExchangeStore\Parser;
namespace Pex;
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
    const CONTACT_LIST = 3;

    /**
     * Constant of the Calendar event list parser
     */
    const CALENDAR_EVENT_LIST = 4;

    /**
     * Constant of the Calendar event list parser
     */
    const CALENDAR_EVENT_CREATE = 5;

    /**
     * Constant of the Task event list parser
     */
    const TASK_LIST = 6;

    /**
     * Constant of the Task event list parser
     */
    const TASK_CREATE = 7;


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
            return $this->_createCreateParser();
        case self::CONTACT_LIST:
            return $this->_createContactListParser();
        case self::CALENDAR_EVENT_LIST:
            return $this->_createCalendarEventListParser();
        case self::CALENDAR_EVENT_CREATE:
            return $this->_createCreateParser();
        case self::TASK_LIST:
            return $this->_createTaskListParser();
        case self::TASK_CREATE:
            return $this->_createCreateParser();

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


    /**
     * Creates a parser
     *
     * @return CreateParser
     */
    private function _createCreateParser()
    {
        include_once dirname(__FILE__).'/CreateParser.php';
        $parser = new CreateParser();
        return $parser;

    }//end _createCreateParser()


    /**
     * Creates a parser
     *
     * @return ContactListParser
     */
    private function _createContactListParser()
    {
        include_once dirname(__FILE__).'/ContactListParser.php';
        $parser = new ContactListParser();
        return $parser;

    }//end _createContactListParser()


    /**
     * Creates a parser
     *
     * @return CalendarEventListParser
     */
    private function _createCalendarEventListParser()
    {
        include_once dirname(__FILE__).'/CalendarEventListParser.php';
        $parser = new CalendarEventListParser();
        return $parser;

    }//end _createCalendarEventListParser()


    /**
     * Creates a parser
     *
     * @return TaskListParser
     */
    private function _createTaskListParser()
    {
        include_once dirname(__FILE__).'/TaskListParser.php';
        $parser = new TaskListParser();
        return $parser;

    }//end _createTaskListParser()


}//end class

?>
