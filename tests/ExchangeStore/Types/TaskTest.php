<?php
/**
 * TaskTest.php
 *
 * Holds the TaskTest class
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
 * @link     http://www.assembla.com/spaces/p-pex
 */

/**
 * The TaskTest class is responsible for ...
 *
 * PHP Version: 5
 *
 * @category Class
 * @package  Test
 * @author   meza <meza@meza.hu>
 * @license  GPL3.0
 *                    GNU GENERAL PUBLIC LICENSE
 *                       Version 3, 29 June 2007
 *
 * Copyright (C) 2007 Free Software Foundation, Inc. <http://fsf.org/>
 * Everyone is permitted to copy and distribute verbatim copies
 * of this license document, but changing it is not allowed.
 * @link     http://www.assembla.com/spaces/p-pex
 */
class TaskTest extends PexTestBase
{

    /**
     * @var Task instance
     */
    protected $object;


    /**
     * Generate a random string for subject
     *
     * @return string
     */
    private function _generateSubject()
    {
        return md5(date('U'));

    }//end _generateSubject()


    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @return void
     */
    protected function setUp()
    {
        $this->object = new Task();

    }//end setUp()


    /**
     * Returns a task regarding subject and priority
     *
     * @param string $subject          The subject to be used
     * @param const  $expectedPriority The priority to be used
     *
     * @return Task
     */
    protected function getExpectedTask($subject, $expectedPriority)
    {
        $expectedTask           = new Task();
        $expectedTask->subject  = $subject;
        $expectedTask->priority = $expectedPriority;

        return $expectedTask;

    }//end getTask()


    /**
     * Test that the shorthand factory creates a normal priority task,
     * with the subject set.
     *
     * @test
     *
     * @return void
     */
    public function testATask()
    {
        $subject  = $this->_generateSubject();
        $actual   = Task::aTask($subject);
        $expected = $this->getExpectedTask($subject, Task::PRIORITY_NORMAL);

        $this->assertEquals($expected, $actual);

    }//end testATask()


    /**
     * Test that the shorthand factory creates a high priority task,
     * with the subject set.
     *
     * @test
     *
     * @return void
     */
    public function testAnUrgentTask()
    {
        $subject  = $this->_generateSubject();
        $actual   = Task::anUrgentTask($subject);
        $expected = $this->getExpectedTask($subject, Task::PRIORITY_HIGH);

        $this->assertEquals($expected, $actual);

    }//end testAnUrgentTask()


    /**
     * Test that the shorthand factory creates a low priority task,
     * with the subject set.
     *
     * @test
     *
     * @return void
     */
    public function testAnUnimportantTask()
    {
        $subject  = $this->_generateSubject();
        $actual   = Task::anUnimportantTask($subject);
        $expected = $this->getExpectedTask($subject, Task::PRIORITY_LOW);

        $this->assertEquals($expected, $actual);

    }//end testAnUnimportantTask()


    public function dateSetterProvider()
    {
        return array(
                array('start', 'from'),
                array('end', 'due'),
                array('end', 'to')
               );
    }


    /**
     * Test that the date setter methods work
     *
     * @dataProvider dateSetterProvider()
     *
     * @test
     *
     * @return void
     */
    public function testDateSetters($field, $method)
    {
        $this->assertNull(
            $this->object->{$field},
            'The initial value of the '.$field.' field is not null'
        );

        $date     = '2010-01-01 12:21:34';
        $expected = date('c', strtotime($date));

        $this->object->{$method}($date);

        $actual = $this->readAttribute($this->object, $field);

        $this->assertEquals(
            $expected,
            $actual,
            'The '.$field.' date is not set to the correct value'
        );

    }//end testDateSetters()


    public function stringSetterProvider()
    {
        return array(
                array('location', 'at'),
                array('description', 'withDescription'),
               );
    }


    /**
     * Test that the date setter methods work
     *
     * @dataProvider stringSetterProvider()
     *
     * @test
     *
     * @return void
     */
    public function testStringSetters($field, $method)
    {
        $this->assertNull(
            $this->object->{$field},
            'The initial value of the '.$field.' field is not null'
        );

        $expected = $this->_generateSubject();

        $this->object->{$method}($expected);

        $actual = $this->readAttribute($this->object, $field);

        $this->assertEquals(
            $expected,
            $actual,
            'The '.$field.' date is not set to the correct value'
        );

    }//end testStringSetters()


    /**
     * Tests the setter and getter for the url
     *
     * @test
     *
     * @return void
     */
    public function testUrlAccess()
    {
        $url = 'some/url';

        $this->assertNull($this->object->getUrl());

        $this->object->setUrl($url);

        $this->assertEquals($url, $this->object->getUrl());

    }//end testUrlAccess()


    /**
     * Test that the date format retrieval works
     *
     * @test
     *
     * @return void
     */
    public function testGetStartDate()
    {
        $this->assertEquals('', $this->object->getStartDate());
        $date = '2010-01-01 12:34:56';
        $this->object->from($date);
        $expected = date('U', strtotime($date));
        $actual   = $this->object->getStartDate('U');

        $this->assertEquals($expected, $actual);

    }//end testGetStartDate()


    /**
     * Test that the date format retrieval works
     *
     * @test
     *
     * @return void
     */
    public function testGetEndDate()
    {
        $this->assertEquals('', $this->object->getEndDate());
        $date = '2010-01-01 12:34:56';
        $this->object->to($date);
        $expected = date('U', strtotime($date));
        $actual   = $this->object->getEndDate('U');

        $this->assertEquals($expected, $actual);

    }//end testGetEndDate()


    /**
     * @test
     *
     * @return void
     */
    public function testGetDueDate()
    {
        $this->assertEquals('', $this->object->getDueDate());
        $date = '2010-01-01 12:34:56';
        $this->object->due($date);
        $expected = date('U', strtotime($date));
        $actual   = $this->object->getDueDate('U');

        $this->assertEquals($expected, $actual);

    }//end testGetDueDate()


    /**
     * Test file as name generation
     *
     * @test
     *
     * @return void
     */
    public function testGetFileAsName()
    {
        $subject = $this->_generateSubject();
        $task    = Task::aTask($subject)->from('2010-01-01 12:34:56');

        $expected = $subject.' '.$task->getStartDate('YmdHi');
        $actual   = $task->getFileAsName();

        $this->assertEquals($expected, $actual);

    }//end testGetFileAsName()


    /**
     * Test the url modifier access
     *
     * @test
     *
     * @return void
     */
    public function testUrlModifierAccess()
    {
        $modifier = $this->_generateSubject();

        $this->assertEquals('', $this->object->getUrlModifier());

        $this->object->setUrlModifier($modifier);

        $this->assertEquals($modifier, $this->object->getUrlModifier());

    }//end testGetUrlModifier()


}//end class

?>
