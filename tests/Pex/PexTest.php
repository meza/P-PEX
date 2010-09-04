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
namespace Pex;
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
        $this->httpFactoryMock   = $this->mock('HttpFactory', array('createHttp'));
        $this->parserFactoryMock = $this->mock('ParserFactory');
        $this->httpMock          = $this->mock('Http');
        $this->parserMock        = $this->mock('Parser', array('parse'));

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
     * @param int $index to use
     *
     * @return httpFactory
     */
    protected function setUpHttpFactory($index=0)
    {
        if ($index >= 0) {
            $this->httpFactoryMock->expects(
                $this->at($index)
            )->method('createHttp')->will($this->returnValue($this->httpMock->mock));
        } else {
            $this->httpFactoryMock->expects(
                $this->any()
            )->method('createHttp')->will($this->returnValue($this->httpMock->mock));
        }

        return $this->httpFactoryMock;

    }//end setUpHttpFactory()


    /**
     * Need to test getHttp method
     *
     * @return void
     */
    public function testGetHttp()
    {
        $httpFactory = $this->setUpHttpFactory();
        $this->object->getHttp($httpFactory->mock);

    }//end testGetHttp()


    /**
     * Test a standard call
     *
     * @return void
     */
    public function testCall()
    {
        $httpFactory = $this->setUpHttpFactory();

        $this->expectRequest(
            $this->httpMock,
            $this->anHttpParam(),
            0,
            $this->anOKResponse()
        );

        $actual = $this->object->call($this->anHttpParam());

        $this->assertEquals($this->anOKResponse(), $actual);

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
        $this->setUpHttpFactory(-1);

        // Send a request, that will need auth.
        $this->expectRequest(
            $this->httpMock,
            $this->anHttpParam(),
            0,
            $this->anUnauthenticatedResponse()
        );

        // Try to login with invalid credentials.
        $this->expectRequest(
            $this->httpMock,
            $this->aLoginHttpParam(),
            1,
            $this->anUnauthenticatedResponse()
        );

        // Try to send the original request again, but with no luck.
        $this->expectRequest(
            $this->httpMock,
            $this->anHttpParam(),
            2,
            $this->anUnauthenticatedResponse()
        );

        // Try a login again.
        $this->expectRequest(
            $this->httpMock,
            $this->aLoginHttpParam(),
            3,
            $this->anUnauthenticatedResponse()
        );

        $this->object->call($this->anHttpParam());

    }//end testCallWithCantLogin()


    /**
     * Test a standard call with login required
     *
     * @return void
     */
    public function testCallWithLoginRequired()
    {
        $storeParams = new ServiceUrlsHttpParams();
        $storeUrls   = new StoreUrlData();
        $urlResult   = $this->aResponse();
        $this->setUpHttpFactory(0);
        $this->setUpHttpFactory(1);
        $this->setUpHttpFactory(2);
        $this->setUpHttpFactory(3);
        $http = $this->httpMock;

        $this->expectRequest(
            $http,
            $this->anHttpParam(),
            0,
            $this->anUnauthenticatedResponse()
        );
        $this->expectRequest(
            $http,
            $this->aLoginHttpParam(),
            1,
            $this->anOKResponse()
        );
        $this->expectRequest($http, $storeParams, 2, $urlResult);
        $this->expectRequest(
            $http,
            $this->anHttpParam(),
            3,
            $this->anOKResponse()
        );

        $this->parserFactoryMock->expects($this->once())->method(
            'createParser'
        )->with($this->equalTo(ParserFactory::STORE_URLS))->will(
            $this->returnValue($this->parserMock->mock)
        );

        $this->parserMock->expects($this->once())->method('parse')->with(
            $this->equalTo($urlResult->data)
        )->will($this->returnValue($storeUrls));

        $actual = $this->object->call($this->anHttpParam());

        $this->assertEquals($this->anOKResponse(), $actual);

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
        $this->object->call($this->anHttpParam('not a very well formed xml'));

    }//end testCallWithInvalidXml()


}//end class

?>
