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
 * @version  $Id$
 * @link     http://www.assembla.com/spaces/p-pex
 **/

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__).'/../../src/Pex/Pex.php';
require_once dirname(__FILE__).'/../../src/Pex/ConnectionData.php';
require_once dirname(__FILE__).'/../../src/Pex/Exceptions/CouldNotLoginException.php';
require_once dirname(__FILE__).'/../../src/Http/Http.php';
require_once dirname(__FILE__).'/../../src/Http/HttpResponse.php';
require_once dirname(__FILE__).'/../../src/Http/HttpFactory.php';
require_once dirname(__FILE__).'/../../src/Http/HttpParams.php';

require_once dirname(__FILE__).'/../../src/ExchangeStore/URLAccess.php';
require_once dirname(__FILE__).'/../../src/ExchangeStore/URLFactory.php';
require_once dirname(__FILE__).'/../../src/ExchangeStore/ExchangeResponse.php';
require_once dirname(__FILE__).'/../../src/ExchangeStore/Parser/Parser.php';
require_once dirname(__FILE__).'/../../src/ExchangeStore/Parser/ParserFactory.php';
require_once dirname(__FILE__).'/../../src/ExchangeStore/Parser/StoreUrlData.php';
require_once dirname(__FILE__).'/../../src/ExchangeStore/Parser/ContactCreateParser.php';
require_once dirname(__FILE__).'/../../src/ExchangeStore/Parser/ContactGetParser.php';
require_once dirname(__FILE__).'/../../src/ExchangeStore/HttpParams/LoginHttpParams.php';
require_once dirname(__FILE__).'/../../src/ExchangeStore/HttpParams/ServiceUrlsHttpParams.php';
require_once dirname(__FILE__).'/../../src/ExchangeStore/HttpParams/ContactCreateHttpParam.php';
require_once dirname(__FILE__).'/../../src/ExchangeStore/HttpParams/ContactGetHttpParam.php';

require_once dirname(__FILE__).'/../_HelperFiles/ContactFactory.php';
require_once dirname(__FILE__).'/../_HelperFiles/ExchangeRawResponseFactory.php';


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
            false,
            false
        );
        $this->httpFactoryMock   = $this->getMock(
            'HttpFactory',
            array('createHttp'),
            array(),
            '',
            false,
            false,
            false
        );

        $this->parserFactoryMock = $this->getMock(
            'ParserFactory',
            array(),
            array(),
            '',
            false,
            false,
            false
        );

        $this->httpMock = $this->getMock(
            'Http',
            array(),
            array(),
            '',
            false,
            false,
            false
        );

        $this->parserMock = $this->getMock(
            'Parser',
            array('parse'),
            array(),
            '',
            false,
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
        if ($index>=0) {
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
     * @todo Implement testGetHttp().
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

        $result = new HttpResponse();
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

        $result = new HttpResponse();
        $result->code = 440;

        $httpFactory = $this->_setUpHttpFactory($this->httpFactoryMock, -1);

        $this->httpMock->expects($this->any())->method('request')
        ->will($this->returnValue($result));

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
     * @todo Implement testParse().
     *
     * @return void
     */
    public function testParse()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );

    }//end testParse()


    /**
     * @todo Implement testLogin().
     *
     * @return void
     */
    public function testLogin()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );

    }//end testLogin()


    /**
     * @todo Implement testGetStoreUrls().
     *
     * @return void
     */
    public function testGetStoreUrls()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );

    }//end testGetStoreUrls()


    private function _setUpContactCreateMocks($url=null)
    {
        $this->parserFactoryMock->expects($this->once())->method(
            'createParser')->with($this->equalTo(
            ParserFactory::CONTACT_CREATE
        ))->will($this->returnValue(new ContactCreateParser()));

        $httpResult = $this->exchangeRawResponseFactory->
            getSuccessfulContactCreationResponse($url);
        $contact    = $this->contactFactory->createAValidContact();
        $param      = new ContactCreateHttpParams($contact);

        $httpFactoryMock = $this->_setUpHttpFactory($this->httpFactoryMock);
        $this->httpMock->expects($this->once())->method('request')->with(
            $this->equalTo($param)
        )->will($this->returnValue($httpResult));

        return $contact;
    }

    public function testCreateContact()
    {
        $url     = 'http://test.com/user1/Contacts/somebody.eml';
        $contact = $this->_setUpContactCreateMocks($url);
        $actual  = $this->object->createContact($contact);
        
        $this->assertEquals($url, $actual);
    }


    public function testGetContact()
    {
        $expectedContact = new Contact();
        $expectedContact->emailAddress = 'test@domain.com';
        $expectedContact->firstName = 'User';
        $expectedContact->lastName = 'Test';
        $expectedContact->nickName = 'tuser';

        $url = 'https://server.com/exchange/user/Contacts/Test%20User.eml';


        $httpResult = $this->exchangeRawResponseFactory->
            getContactResponse($url);
        $param      = new ContactGetHttpParams($url);

        $httpFactoryMock = $this->_setUpHttpFactory($this->httpFactoryMock);
        $this->httpMock->expects($this->once())->method('request')->with(
            $this->equalTo($param)
        )->will($this->returnValue($httpResult));


        $this->parserFactoryMock->expects($this->once())->method(
            'createParser')->with($this->equalTo(
            ParserFactory::CONTACT_GET
        ))->will($this->returnValue(new ContactGetParser()));


        $actual = $this->object->readContact($url);
        $this->assertEquals($expectedContact, $actual);
    }

}//end class

?>
