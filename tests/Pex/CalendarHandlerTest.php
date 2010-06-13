<?php
/**
 * CalendarHandlerTest.php
 *
 * Holds the CalendarHandlerTest class
 *
 * PHP Version: 5
 *
 * @category File
 * @package
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
 * The CalendarHandlerTest class is responsible for ...
 *
 * PHP Version: 5
 *
 * @category Class
 * @package
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
class CalendarHandlerTest extends PexTest
{


    /**
     * Sets up the tests
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();
        $this->setUpHttpFactory(-1);

    }//end setUp()


    /**
     * tets
     *
     * @test
     *
     * @return void
     */
    public function testCreateEvent()
    {
        $createParams = new CalendarEventCreateHttpParam(
            $this->_aDummyEvent(),
            $this->connectionData->username
        );
        $checkParams  = new CalendarEventCheckHttpParam($this->_aDummyEvent());
        $response     = 'a dummy response';

        $this->expectRequest(
            $this->httpMock,
            $checkParams,
            0,
            $this->aNotFoundResponse()
        );

        $this->expectRequest(
            $this->httpMock,
            $createParams,
            1,
            $this->anOKResponse($response)
        );

        $this->parserFactoryMock->expects($this->once())->method(
            'createParser'
        )->with($this->equalTo(ParserFactory::CALENDAR_EVENT_CREATE))->will(
            $this->returnValue($this->parserMock->mock)
        );

        $this->parserMock->expects($this->once())->method('parse')->with(
            $this->equalTo($response)
        )->will($this->returnValue('dummy'));

        $this->object->createEvent($this->_aDummyEvent());


    }//end testCreateEvent()


    /**
     * tets
     *
     * @test
     *
     * @return void
     */
    public function testCreateEventWithExistingUrl()
    {
        $checkParamsA = new CalendarEventCheckHttpParam($this->_aDummyEvent());
        $event        = $this->_aDummyEvent();
        $event->setUrlModifier(md5(date('Y-m-d H:i')));

        $checkParamsB = new CalendarEventCheckHttpParam($event);
        $createParams = new CalendarEventCreateHttpParam($event, $this->connectionData->username);
        $response     = 'a dummy response';

        $this->expectRequest($this->httpMock, $checkParamsA, 0);

        $this->expectRequest(
            $this->httpMock,
            $checkParamsB,
            1,
            $this->aNotFoundResponse()
        );

        $this->expectRequest(
            $this->httpMock,
            $createParams,
            2,
            $this->anOKResponse($response)
        );

        $this->parserFactoryMock->expects($this->once())->method(
            'createParser'
        )->with($this->equalTo(ParserFactory::CALENDAR_EVENT_CREATE))->will(
            $this->returnValue($this->parserMock->mock)
        );

        $this->parserMock->expects($this->once())->method('parse')->with(
            $this->equalTo($response)
        )->will($this->returnValue('dummy'));

        $this->object->createEvent($this->_aDummyEvent());

    }//end testCreateEventWithExistingUrl()


    /**
     * Test that event update works
     *
     * @return void
     */
    public function testUpdateEvent()
    {
        $url          = 'some/url';
        $eventWithUrl = $this->_aDummyEvent();
        $response     = 'dummy resp';
        $eventWithUrl->setUrl($url);

        $params      = new CalendarEventCreateHttpParam(
            $this->_aDummyEvent(),
            $this->connectionData->username
        );
        $params->url = $url;

        $this->expectRequest(
            $this->httpMock,
            $params,
            0,
            $this->anOKResponse($response)
        );

        $this->parserFactoryMock->expects($this->once())->method(
            'createParser'
        )->with($this->equalTo(ParserFactory::CALENDAR_EVENT_CREATE))->will(
            $this->returnValue($this->parserMock->mock)
        );

        $this->parserMock->expects($this->once())->method('parse')->with(
            $this->equalTo($response)
        )->will($this->returnValue('dummy'));

        $this->object->updateEvent($eventWithUrl);

    }//end testUpdateEvent()


    /**
     * tets
     *
     * @test
     *
     * @return void
     */
    public function testDeleteEvent()
    {
        $params = new CalendarEventDeleteHttpParam($this->_aDummyEvent());
        $this->expectRequest($this->httpMock, $params, 0);

        $actual = $this->object->deleteEvent($this->_aDummyEvent());
        $this->assertTrue($actual);

    }//end testDeleteEvent()


    /**
     * tets
     *
     * @test
     *
     * @return void
     */
    public function testDeleteEventWithFailure()
    {
        $params = new CalendarEventDeleteHttpParam($this->_aDummyEvent());
        $this->expectRequest(
            $this->httpMock,
            $params,
            0,
            $this->aNotFoundResponse()
        );

        $actual = $this->object->deleteEvent($this->_aDummyEvent());
        $this->assertFalse($actual);

    }//end testDeleteEventWithFailure()


    /**
     * tets
     *
     * @test
     *
     * @return void
     */
    public function testListEvents()
    {
        $params   = new CalendarEventListHttpParam();
        $response = 'dummy data';

        $this->expectRequest(
            $this->httpMock,
            $params,
            0,
            $this->anOkResponse($response)
        );

        $this->parserFactoryMock->expects($this->once())->method(
            'createParser'
        )->with($this->equalTo(ParserFactory::CALENDAR_EVENT_LIST))->will(
            $this->returnValue($this->parserMock->mock)
        );

        $this->parserMock->expects($this->once())->method('parse')->with(
            $this->equalTo($response)
        )->will($this->returnValue('dummy'));

        $this->object->listEvents();

    }//end testListEvents()


    /**
     * Creates a dummy event
     *
     * @return CalendarEvent
     */
    private function _aDummyEvent()
    {
        $event = CalendarEvent::anEvent('subject')->at('some place');
        $event->from('2010-01-01')->to('2011-01-01')->withDescription('desc');

        return $event;

    }//end _aDummyEvent();

}//end class

?>