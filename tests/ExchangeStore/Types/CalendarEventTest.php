<?php
/**
 * CalendarEventTest.php
 *
 * Holds the CalendarEvent class test
 *
 * PHP Version: 5
 *
 * @category File
 * @package  Calendar
 * @author   meza <meza@meza.hu>
 * @license  GPL3.0
 *                    GNU GENERAL PUBLIC LICENSE
 *                       Version 3, 29 June 2007
 *
 * Copyright (C) 2007 Free Software Foundation, Inc. <http://fsf.org/>
 * Everyone is permitted to copy and distribute verbatim copies
 * of this license document, but changing it is not allowed.
 * *
 * @link     http://www.assembla.com/spaces/p-pex
 */

/**
 * The CalendarEventTest class is responsible for testing the calendar event
 * class
 *
 * PHP Version: 5
 *
 * @category Class
 * @package  Test
 * @author   meza <meza@meza.hu>
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 */
class CalendarEventTest extends MockAmendingTestCaseBase
{

    /**
     * @var CalendarEvent instance
     */
    protected $object;


    /**
     * Sets up the fixtures
     *
     * @return Void
     */
    protected function setUp()
    {
        date_default_timezone_set('Europe/Budapest');
        $this->object = new CalendarEvent();

    }//end setUp()


    /**
     * We need to test that the subject is mandatory
     *
     * @expectedException Exception
     *
     * @return void;
     */
    public function testAnEventSubject()
    {
        $event = CalendarEvent::anEvent();

    }//end testAnEventSubject()


    /**
     * We need to test that the CalendarEvent is created as we expect it
     *
     * @return void
     */
    public function testAnEvent()
    {
        $expectedSubject = 'Subject';
        $event           = CalendarEvent::anEvent($expectedSubject);

        $this->assertAttributeEquals($expectedSubject, 'subject', $event);
        $this->assertType('CalendarEvent', $event);

    }//end testAnEvent()


    /**
     * We need to make sure the from() needs it's argument
     *
     * @expectedException Exception
     *
     * @return void
     */
    public function testFromMissingArgument()
    {
        $this->object->from();

    }//end testFromMissingArgument()


    /**
     * Returns various types of dates that could be given through the api
     * 
     * @return array of strings
     */
    public function dateProvider()
    {
        $dates = array(
                  array(
                   '2010-01-01 21:00',
                    date('c', strtotime('2010-01-01 21:00')),
                  ),
                  array(
                   '2010-01-01T21:00:00Z',
                   date('c', strtotime('2010-01-01T21:00:00Z')),
                  ),
                  array(
                   '2010-01-01T21:00:00+02:00',
                   date('c', strtotime('2010-01-01T21:00:00+02:00')),
                  ),
                  array(
                   '2010-01-01T21:00:00+04:00',
                   date('c', strtotime('2010-01-01T21:00:00+04:00')),
                  ),
                  array(
                   '10/05/01',
                   date('c', strtotime('10/05/01')),
                  ),
                 );

        return $dates;

    }//end dateProvider()


    /**
     * We need to test that the from() sets the start date to the ISO 8601 date
     *
     * @param string $date     The input date
     * @param string $expected The expected stored value
     *
     * @dataProvider dateProvider()
     *
     * @return void
     */
    public function testFrom($date, $expected)
    {
        $this->object->from($date);
        $this->assertAttributeEquals($expected, 'start', $this->object);

    }//end testFrom()


    /**
     * We need to make sure the to() needs it's argument
     *
     * @expectedException Exception
     *
     * @return void
     */
    public function testToMissingArgument()
    {
        $this->object->to();

    }//end testToMissingArgument()


    /**
     * We need to test that the to() sets the start date to the ISO 8601 date
     *
     * @param string $date     The input date
     * @param string $expected The expected stored value
     *
     * @dataProvider dateProvider()
     *
     * @return void
     */
    public function testTo($date, $expected)
    {
        $this->object->to($date);
        $this->assertAttributeEquals($expected, 'end', $this->object);

    }//end testTo()


    /**
     * We need to make sure the at() needs it's argument
     *
     * @expectedException Exception
     *
     * @return void
     */
    public function testAtMissingArgument()
    {
        $this->object->at();

    }//end testAtMissingArgument()


    /**
     * We need to make sure the at() sets the location
     *
     * @return void
     */
    public function testAt()
    {
        $expected = 'an example location';
        $this->object->at($expected);
        $this->assertAttributeEquals($expected, 'location', $this->object);

    }//end testAt()


    /**
     * We need to make sure the withDescription() needs it's argument
     *
     * @expectedException Exception
     *
     * @return void
     */
    public function testWithDescriptionMissingArgument()
    {
        $this->object->withDescription();

    }//end testWithDescriptionMissingArgument()


    /**
     * We need to make sure the withDescription() sets the location
     *
     * @return void
     */
    public function testWithDescription()
    {
        $expected = 'an example description';
        $this->object->withDescription($expected);
        $this->assertAttributeEquals($expected, 'description', $this->object);

    }//end testWithDescription()


    /**
     * We need to make sure the withSubject() needs it's argument
     *
     * @expectedException Exception
     *
     * @return void
     */
    public function testWithSubjectMissingArgument()
    {
        $this->object->withSubject();

    }//end testWithSubjectMissingArgument()


    /**
     * We need to make sure the withSubject() sets the location
     *
     * @return void
     */
    public function testWithSubject()
    {
        $expected = 'an example subject';
        $this->object->withSubject($expected);
        $this->assertAttributeEquals($expected, 'subject', $this->object);

    }//end testWithSubject()


    /**
     * We need to make sure the setUrl() needs it's argument
     *
     * @expectedException Exception
     *
     * @return void
     */
    public function testSetUrlMissingArgument()
    {
        $this->object->setUrl();

    }//end testSetUrlMissingArgument()


    /**
     * We need to be sure that the url is set
     *
     * @return void
     */
    public function testSetUrl()
    {
        $expectedUrl = 'http://some.url/';
        $this->object->setUrl($expectedUrl);

        $this->assertAttributeEquals($expectedUrl, '_url', $this->object);

    }//end testSetUrl()


    /**
     * We need to be sure that the url is returned
     *
     * @return void
     */
    public function testGetUrl()
    {
        $expectedUrl = 'http://some.url/';
        $this->object->setUrl($expectedUrl);
        $actual = $this->object->getUrl();
        $this->assertEquals($expectedUrl, $actual);

    }//end testGetUrl()


    /**
     * Checks if the two dates match
     *
     * @param string $d1     The base date (needed to be converted)
     * @param string $actual The actual date
     *
     * @return void
     */
    private function _assertEventDateMatches($d1, $actual)
    {
        $expected = date(CalendarEvent::DEFAULT_DATE_FORMAT, strtotime($d1));
        $this->assertEquals($expected, $actual);

    }//end _assertEventDateMatches()


    /**
     * We need to check if the correct date is returned
     *
     * @param string $baseExpectedDate The base date to be expected
     * @param string $stored           The date stored in the event
     *
     * @dataProvider dateProvider()
     *
     * @return void
     */
    public function testGetStartDate($baseExpectedDate, $stored)
    {
        $this->object->start = $stored;
        $actual              = $this->object->getStartDate();
        $this->_assertEventDateMatches($baseExpectedDate, $actual);

    }//end testGetStartDate()


    /**
     * We need to check if the correct date is returned
     *
     * @dataProvider dateProvider()
     *
     * @return void
     */
    public function testGetEndDate($baseExpectedDate, $stored)
    {
        $this->object->end = $stored;
        $actual            = $this->object->getEndDate();
        $this->_assertEventDateMatches($baseExpectedDate, $actual);

    }//end testGetEndDate()


}//end class

?>
