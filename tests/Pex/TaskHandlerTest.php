<?php
/**
 * TaskHandlerTest.php
 *
 * Holds the TaskHandlerTest class
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
 * The TaskHandlerTest class is responsible for ...
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
class TaskHandlerTest extends PexTest
{

    protected $username = 'demo username';

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
    public function testCreateTask()
    {
        $createParams = new TaskCreateHttpParam(
            $this->_aDummyTask(),
            $this->username
        );
        $checkParams  = new TaskCheckHttpParam($this->_aDummyTask());
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
        )->with($this->equalTo(ParserFactory::TASK_CREATE))->will(
            $this->returnValue($this->parserMock->mock)
        );

        $this->parserMock->expects($this->once())->method('parse')->with(
            $this->equalTo($response)
        )->will($this->returnValue('dummy'));

        $this->object->createTask($this->_aDummyTask());
        
    }//end testCreateTask()


    /**
     * tets
     *
     * @test
     *
     * @return void
     */
    public function testCreateTaskWhenAlreadyExists()
    {
        $checkParamsA = new TaskCheckHttpParam($this->_aDummyTask());
        $task        = $this->_aDummyTask();
        $task->setUrlModifier(md5(date('Y-m-d H:i')));

        $checkParamsB = new TaskCheckHttpParam($task);
        $createParams = new TaskCreateHttpParam($task, $this->username);
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
        )->with($this->equalTo(ParserFactory::TASK_CREATE))->will(
            $this->returnValue($this->parserMock->mock)
        );

        $this->parserMock->expects($this->once())->method('parse')->with(
            $this->equalTo($response)
        )->will($this->returnValue('dummy'));

        $this->object->createTask($this->_aDummyTask());

    }//end testCreateTaskWhenAlreadyExists()


    /**
     * tets
     *
     * @test
     *
     * @return void
     */
    public function testUpdateTask()
    {
        $url         = 'some/url';
        $taskWithUrl = $this->_aDummyTask();
        $response    = 'dummy resp';
        $taskWithUrl->setUrl($url);

        $params      = new TaskCreateHttpParam(
            $this->_aDummyTask(),
            $this->username
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
        )->with($this->equalTo(ParserFactory::TASK_CREATE))->will(
            $this->returnValue($this->parserMock->mock)
        );

        $this->parserMock->expects($this->once())->method('parse')->with(
            $this->equalTo($response)
        )->will($this->returnValue('dummy'));

        $this->object->updateTask($taskWithUrl);

    }//end testUpdateTask()


    /**
     * tets
     *
     * @test
     *
     * @return void
     */
    public function testDeleteTask()
    {
        $params = new TaskDeleteHttpParam($this->_aDummyTask());
        $this->expectRequest($this->httpMock, $params, 0);

        $actual = $this->object->deleteTask($this->_aDummyTask());
        $this->assertTrue($actual);

    }//end testDeleteTask()


    /**
     * tets
     *
     * @test
     *
     * @return void
     */
    public function testDeleteTaskFailure()
    {
        $params = new TaskDeleteHttpParam($this->_aDummyTask());
        $this->expectRequest(
            $this->httpMock,
            $params,
            0,
            $this->aNotFoundResponse()
        );

        $actual = $this->object->deleteTask($this->_aDummyTask());
        $this->assertFalse($actual);

    }//end testDeleteTaskFailure()


    /**
     * tets
     *
     * @test
     *
     * @return void
     */
    public function testListTasks()
    {
        $params   = new TaskListHttpParam();
        $response = 'dummy data';

        $this->expectRequest(
            $this->httpMock,
            $params,
            0,
            $this->anOkResponse($response)
        );

        $this->parserFactoryMock->expects($this->once())->method(
            'createParser'
        )->with($this->equalTo(ParserFactory::TASK_LIST))->will(
            $this->returnValue($this->parserMock->mock)
        );

        $this->parserMock->expects($this->once())->method('parse')->with(
            $this->equalTo($response)
        )->will($this->returnValue('dummy'));

        $this->object->listTasks();

    }//end testListTasks()


    /**
     * Generates a dummy task
     *
     * @return Task
     */
    private function _aDummyTask()
    {
        $task = Task::anUnimportantTask('A dummy subject')->due('2011-01-01');
        $task->withDescription('someDescription')->at('some place');

        return $task;

    }//end _aDummyTask()


}//end class

?>