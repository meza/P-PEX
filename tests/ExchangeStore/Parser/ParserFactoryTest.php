<?php
/**
 * ParserFactoryTest.php
 *
 * Holds the Test for the ParserFactory class
 *
 * PHP Version: 5
 *
 * @category File
 * @package  Test
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
namespace Pex;
/**
 * The ParserFactoryTest class is the unittest class for the ParserFactory class
 *
 * PHP Version: 5
 *
 * @category Class
 * @package  Test
 * @author   meza <meza@meza.hu>
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 */
class ParserFactoryTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var ParserFactory object
     */
    protected $object;


    /**
     * Sets up the excercised objec
     *
     * @return void;
     */
    protected function setUp()
    {
        $this->object = new ParserFactory;

    }//end setUp()


    /**
     * Data provider for testCreateParser()
     *
     * @return array of arguments
     */
    public function parserProvider()
    {
        return array(
                array(
                 ParserFactory::STORE_URLS,
                 'StoreUrlParser',
                ),
                array(
                 ParserFactory::CONTACT_CREATE,
                 'CreateParser',
                ),
                array(
                 ParserFactory::CONTACT_LIST,
                 'ContactListParser',
                ),
                array(
                 ParserFactory::TASK_LIST,
                 'TaskListParser',
                ),
                array(
                 ParserFactory::TASK_CREATE,
                 'CreateParser',
                ),
                array(
                 ParserFactory::CALENDAR_EVENT_LIST,
                 'CalendarEventListParser',
                ),
                array(
                 ParserFactory::CALENDAR_EVENT_CREATE,
                 'CreateParser',
                ),
               );

    }//end parserProvider()


    /**
     * We need to test that the createParser method gives the correct objects
     * for the correct input. We'll use a data provider to leave opportunities for
     * further parsers to come.
     *
     * @param int    $type     The type of parser to request
     * @param string $expected The expected return object type
     *
     * @dataProvider parserProvider();
     * @test
     *
     * @return void;
     */
    public function testCreateParser($type, $expected)
    {
        $actual = $this->object->createParser($type);
        $this->assertType($expected, $actual);

    }//end testCreateParser()


    /**
     * We'd like to test that the factory throws the expected exception
     * when an unknown parser was requested from it.
     *
     * @expectedException NoSuchParserException
     * @test
     *
     * @return void;
     */
    public function testException()
    {
        $this->object->createParser('NotExistingParserObject');

    }//end testException()


}//end class

?>
