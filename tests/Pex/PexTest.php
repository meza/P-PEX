<?php
/**
 * PexTest.php
 *
 * Holds the test cases for the Pex class
 *
 * PHP Version: 5
 *
 * @category File
 * @package  Test
 *
 * @author   meza <meza@meza.hu>
 * @license  GPL3.0
 *                    GNU GENERAL PUBLIC LICENSE
 *                       Version 3, 29 June 2007
 *
 * Copyright (C) 2007 Free Software Foundation, Inc. <http://fsf.org/>
 * Everyone is permitted to copy and distribute verbatim copies
 * of this license document, but changing it is not allowed.
 * @link     http://www.assembla.com/spaces/p-pex
 **/

/**
 * The test class of the Pex class
 *
 * PHP Version: 5
 *
 * @category Class
 * @package  Test
 * @author   meza <meza@meza.hu>
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 */
class PexTest extends PexTestBase
{

    /**
     * @var Pex instance
     */
    protected $object;

    /**
     * @var ConnectionData instance
     */
    protected $connectionData;

    /**
     * @var URLAccess mock
     */
    protected $urlAccessMock;

    /**
     * @var HttpFactory mock
     */
    protected $httpFactoryMock;

    /**
     * @var ParserFactory mock
     */
    protected $parserFactoryMock;

    /**
     * @var Http mock
     */
    protected $httpMock;

    /**
     * @var Parser mock
     */
    protected $parserMock;

    /**
     * @var ContactFactory instance
     */
    protected $contactFactory;

    /**
     * @var ExchangeRawResponseFactory instance
     */
    protected $exchangeRawResponseFactory;


    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @return void
     */
    protected function setUp()
    {
        $this->contactFactory             = new ContactFactory();
        $this->exchangeRawResponseFactory = new ExchangeRawResponseFactory();
        $this->connectionData             = new ConnectionData();

        $this->urlAccessMock     = $this->mock('URLAccess');
        $this->httpFactoryMock   = $this->mock('HttpFactory',array('createHttp'));
        $this->parserFactoryMock = $this->mock('ParserFactory');
        $this->httpMock          = $this->mock('Http');
        $this->parserMock        = $this->mock('Parser',array('parse'));

        $this->object = new Pex(
            $this->connectionData,
            $this->urlAccessMock->mock,
            $this->httpFactoryMock->mock,
            $this->parserFactoryMock->mock
        );

    }//end setUp()


    /**
     * Sets up the http factory
     *
     * @param MockObject $httpFactoryMock to set
     * @param int        $index           to use
     *
     * @return httpFactory
     */
    private function _setUpHttpFactory(MockObjectWrapper $httpFactoryMock, $index=0)
    {
        if ($index >= 0) {
            $httpFactoryMock->expects(
                $this->at($index)
            )->method('createHttp')->will($this->returnValue($this->httpMock->mock));
        } else {
            $httpFactoryMock->expects(
                $this->any()
            )->method('createHttp')->will($this->returnValue($this->httpMock->mock));
        }

        return $httpFactoryMock;

    }//end _setUpHttpFactory()


    /**
     * Need to test getHttp method
     *
     * @return void
     */
    public function testGetHttp()
    {
        $httpFactory = $this->_setUpHttpFactory($this->httpFactoryMock);
        $this->object->getHttp($httpFactory->mock);

    }//end testGetHttp()


    /**
     * Test a standard call
     *
     * @return void
     */
    public function testCall()
    {
        $params = new HttpParams();
        $result = $this->anOKResponse();

        $httpFactory = $this->_setUpHttpFactory($this->httpFactoryMock);

        $this->httpMock->expects($this->once())->method('request')->with(
            $this->equalTo($params)
        )->will($this->returnValue($result));

        $actual = $this->object->call($params);

        $this->assertEquals($result, $actual);

    }//end testCall()


    /**
     * Test a standard call when it can't log in
     *
     * @expectedException CouldNotLoginException
     *
     * @return void
     */
    public function testCallWithCantLogin()
    {
        $params      = new HttpParams();
        $result      = $this->anUnauthenticatedResponse();
        $httpFactory = $this->_setUpHttpFactory($this->httpFactoryMock, -1);

        $this->httpMock->expects($this->any())->method('request')->will(
            $this->returnValue($result)
        );

        $this->object->call($params);

    }//end testCallWithCantLogin()


    /**
     * Test a standard call with login required
     *
     * @return void
     */
    public function testCallWithLoginRequired()
    {
        $params      = new HttpParams();
        $loginParams = new LoginHttpParams('', '', '');
        $storeParams = new ServiceUrlsHttpParams();
        $storeUrls   = new StoreUrlData();
        $resultOk    = $this->anOKResponse();
        $resultFail  = $this->anUnauthenticatedResponse();
        $loginResult = $this->anOKResponse();
        $urlResult   = $this->aResponse();
        $httpFactory = $this->_setUpHttpFactory($this->httpFactoryMock);
        $httpFactory = $this->_setUpHttpFactory($httpFactory, 1);
        $httpFactory = $this->_setUpHttpFactory($httpFactory, 2);
        $httpFactory = $this->_setUpHttpFactory($httpFactory, 3);

        $this->httpMock->expects($this->at(0))->method('request')->with(
            $this->equalTo($params)
        )->will($this->returnValue($resultFail));

        $this->httpMock->expects($this->at(1))->method('request')->with(
            $this->equalTo($loginParams)
        )->will($this->returnValue($loginResult));

        $this->httpMock->expects($this->at(2))->method('request')->with(
            $this->equalTo($storeParams)
        )->will($this->returnValue($urlResult));

        $this->parserFactoryMock->expects($this->once())->method(
            'createParser'
        )->with($this->equalTo(ParserFactory::STORE_URLS))->will(
            $this->returnValue($this->parserMock->mock)
        );

        $this->parserMock->expects($this->once())->method('parse')->with(
            $this->equalTo($urlResult->data)
        )->will($this->returnValue($storeUrls));

        $this->httpMock->expects($this->at(3))->method('request')->with(
            $this->equalTo($params)
        )->will($this->returnValue($resultOk));

        $actual = $this->object->call($params);

        $this->assertEquals($resultOk, $actual);

    }//end testCallWithLoginRequired()


    /**
     * Test that it complains about faulty xml
     *
     * @expectedException Exception
     *
     * @return void
     */
    public function testCallWithInvalidXml()
    {
        $param       = new HttpParams();
        $param->data = 'not a very well formed xml';

        $this->object->call($param);

    }//end testCallWithInvalidXml()


}//end class

?>
