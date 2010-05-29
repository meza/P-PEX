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
class PexTest extends PHPUnit_Framework_TestCase
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
        $this->urlAccessMock              = $this->getMock(
            'URLAccess',
            array(),
            array(),
            '',
            false,
            false
        );
        $this->httpFactoryMock = $this->getMock(
            'HttpFactory',
            array('createHttp'),
            array(),
            '',
            false,
            false
        );

        $this->parserFactoryMock = $this->getMock(
            'ParserFactory',
            array(),
            array(),
            '',
            false,
            false
        );

        $this->httpMock = $this->getMock(
            'Http',
            array(),
            array(),
            '',
            false,
            false
        );

        $this->parserMock = $this->getMock(
            'Parser',
            array('parse'),
            array(),
            '',
            false,
            false
        );

        $this->object = new Pex(
            $this->connectionData,
            $this->urlAccessMock,
            $this->httpFactoryMock,
            $this->parserFactoryMock
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
    private function _setUpHttpFactory(HttpFactory $httpFactoryMock, $index=0)
    {
        if ($index >= 0) {
            $httpFactoryMock->expects(
                $this->at($index)
            )->method('createHttp')->will($this->returnValue($this->httpMock));
        } else {
            $httpFactoryMock->expects(
                $this->any()
            )->method('createHttp')->will($this->returnValue($this->httpMock));
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
        $this->object->getHttp($httpFactory);

    }//end testGetHttp()


    /**
     * Test a standard call
     *
     * @return void
     */
    public function testCall()
    {
        $params = new HttpParams();

        $result       = new HttpResponse();
        $result->code = 200;
        $result->data = 'result';

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
        $params = new HttpParams();

        $result       = new HttpResponse();
        $result->code = 440;

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

        $resultOk       = new HttpResponse();
        $resultOk->code = 200;
        $resultOk->data = 'result';

        $resultFail       = new HttpResponse();
        $resultFail->code = 440;
        $resultFail->data = 'result';

        $loginResult       = new HttpResponse();
        $loginResult->code = 200;

        $urlResult       = new HttpResponse();
        $urlResult->data = 'data';

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
            $this->returnValue($this->parserMock)
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
