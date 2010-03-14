<?php
/**
 * CurlBuilderTest.php
 *
 * Holds the Test for the CurlBuilder class
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
 * @version  GIT: $Id: 0bd46a9982bf806ef81107812d33ae05617b8096 $
 * @link     http://www.assembla.com/spaces/p-pex
 */

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__).'/../../src/Http/CurlBuilder.php';
require_once dirname(__FILE__).'/../../src/Http/Curl.php';

/**
 * The CurlBuilderTest class is the unittest class for the CurlBuilder class
 *
 * PHP Version: 5
 *
 * @category Class
 * @package  Test
 * @author   meza <meza@meza.hu>
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 */
class CurlBuilderTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var CurlBuilder
     */
    protected $object;

    /**
     * @var Curl mock
     */
    protected $curlMock;

    /**
     * @var URLFactory mock
     */
    protected $urlFactoryMock;


    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @return void
     */
    protected function setUp()
    {
        $this->urlFactoryMock = $this->getMock(
            'URLFactory',
            array('getUrlFor'),
            array(),
            '',
            false,
            false,
            false
        );
        $this->object         = new CurlBuilder($this->urlFactoryMock);

    }//end setUp()


    /**
     * Sets up a full httpparams
     *
     * @return HttpParams
     */
    private function _setUpHttpParamsFull()
    {
        $httpParamsMock               = $this->getMock('HttpParams');
        $httpParamsMock->headers      = array();
        $httpParamsMock->httpMethod   = 'post';
        $httpParamsMock->httpPassword = 'htPass';
        $httpParamsMock->httpUsername = 'htUser';
        $httpParamsMock->data         = 'htdata';
        $httpParamsMock->referrer     = 'referrer';
        $httpParamsMock->customMethod = 'search';
        $httpParamsMock->url          = 'urlurl';
        $httpParamsMock->userAgent    = 'testUA';

        return $httpParamsMock;

    }//end _setUpHttpParamsFull()


    /**
     * Check that the object needs it's dependency
     *
     * @expectedException Exception
     * @test
     *
     * @return void
     */
    public function testConstructWithoutUrlFactory()
    {
        $curlBuilder = new CurlBuilder();

    }//end testConstructWithoutUrlFactory()


    /**
     * cover createHttp. The real test is in testPrepareCurl
     *
     * @test
     *
     * @return void
     */
    public function testCreateHttp()
    {
        $httpParamsMock      = $this->_setUpHttpParamsFull();
        $httpParamsMock->url = 'login';

        $this->urlFactoryMock->expects($this->at(0))->method(
            'getUrlFor'
        )->with('referrer')->will($this->returnValue('referrerurl'));

        $this->urlFactoryMock->expects($this->at(1))->method(
            'getUrlFor'
        )->with('login')->will($this->returnValue('loginurl'));

        $this->object->createCurl($httpParamsMock, array());

    }//end testCreateHttp()


    /**
     * Returns a configed curl mock
     *
     * @param HttpParams $params Config
     * @param array      $config Config
     *
     * @return Curl
     */
    private function _setCurlExpectations(
        HttpParams $params,
        array $config=array()
    ) {
        $curlMock = $this->getMock(
            'Curl',
            array(
             'setReturnTransfer',
             'verbose',
             'returnHeaders',
             'setHeaders',
             'setData',
             'setPost',
             'setReferrer',
             'setUrl',
             'setCustomMethod',
             'setAuth',
             'setCookieStore',
             'followLocation',
             'setSSLVerifyHost',
             'setSSLVerifyPeer',
            )
        );

        $curlMock->expects($this->at(0))->method(
            'setReturnTransfer'
        )->with($this->equalTo(true));

        $curlMock->expects($this->at(1))->method(
            'verbose'
        )->with($this->equalTo(false));

        $curlMock->expects($this->at(2))->method(
            'returnHeaders'
        )->with($this->equalTo(false));

        $i = 3;
        if (true === isset($config['cookieStore'])) {
            $curlMock->expects($this->at($i))->method(
                'setCookieStore'
            )->with($this->equalTo($config['cookieStore']));
            $i++;
        }

        if (true === isset($config['followLocation'])) {
            $curlMock->expects($this->at($i))->method(
                'followLocation'
            )->with($this->equalTo($config['followLocation']));
            $i++;
        }

        if (true === isset($config['SSLVerifyHost'])) {
            $curlMock->expects($this->at($i))->method(
                'setSSLVerifyHost'
            )->with($this->equalTo($config['SSLVerifyHost']));
            $i++;
        }

        if (true === isset($config['SSLVerifyPeer'])) {
            $curlMock->expects($this->at($i))->method(
                'setSSLVerifyPeer'
            )->with($this->equalTo($config['SSLVerifyPeer']));
            $i++;
        }

        if (true === isset($config['verbose'])) {
            $curlMock->expects($this->at($i))->method(
                'verbose'
            )->with($this->equalTo($config['verbose']));
            $i++;
        }

        if (true === isset($config['returnTransfer'])) {
            $curlMock->expects($this->at($i))->method(
                'setReturnTransfer'
            )->with($this->equalTo($config['returnTransfer']));
            $i++;
        }

        $headers = array();
        foreach ($params->headers as $key => $value) {
            if (true === is_numeric($key)) {
                $headers[] = $value;
            } else {
                $headers[] = $key.': '.$value;
            }
        }

        $headers[] = 'User-Agent: '.$params->userAgent;

        $curlMock->expects($this->at($i))->method(
            'setHeaders'
        )->with($this->equalTo($headers));
        $i++;

        if (null !== $params->data) {
            $curlMock->expects($this->at($i))->method(
                'setData'
            )->with($this->equalTo($params->data));
            $i++;
        }

        if ('POST' === strtoupper($params->httpMethod)) {
            $curlMock->expects($this->at($i))->method(
                'setPost'
            )->with($this->equalTo(true));
            $i++;
        }

        $y = 0;
        if (null !== $params->referrer) {
            $this->urlFactoryMock->expects($this->at($y))->method(
                'getUrlFor'
            )->with($params->referrer)->will($this->returnValue('givenreferrer'));

            $curlMock->expects($this->at($i))->method(
                'setReferrer'
            )->with($this->equalTo('givenreferrer'));
            $i++;
            $y++;
        }

        $this->urlFactoryMock->expects($this->at($y))->method(
            'getUrlFor'
        )->with($params->url)->will($this->returnValue('givenurl'));

        $curlMock->expects($this->at($i))->method(
            'setUrl'
        )->with($this->equalTo('givenurl'));
        $i++;
        $y++;

        if (null !== $params->customMethod) {
            $curlMock->expects($this->at($i))->method(
                'setCustomMethod'
            )->with($this->equalTo(strtoupper($params->customMethod)));
            $i++;
        }

        if (null !== $params->httpUsername && null !== $params->httpPassword) {
            $curlMock->expects($this->at($i))->method(
                'setAuth'
            )->with(
                $this->equalTo($params->httpUsername),
                $this->equalTo($params->httpPassword),
                $this->equalTo(CURLAUTH_BASIC)
            );
            $i++;
        }

        return $curlMock;

    }//end _setCurlExpectations()


    /**
     * Test the prepareCurl method
     *
     * @test
     *
     * @return void
     */
    public function testPrepareCurlWithMinimum()
    {
        $httpParams               = $this->_setUpHttpParamsFull();
        $httpParams->headers      = array();
        $httpParams->httpMethod   = 'get';
        $httpParams->data         = null;
        $httpParams->httpPassword = null;
        $httpParams->httpUsername = null;
        $httpParams->referrer     = null;
        $httpParams->customMethod = null;
        $curlMock                 = $this->_setCurlExpectations($httpParams);

        $this->object->prepareCurl($curlMock, $httpParams);

    }//end testPrepareCurlWithMinimum()


    /**
     * Test the prepareCurl method with all data
     *
     * @test
     *
     * @return void
     */
    public function testPrepareCurlWithMaximum()
    {
        $httpParams          = $this->_setUpHttpParamsFull();
        $httpParams->headers = array(
                                'Content-Type'   => 'text/xml',
                                'Content-Length' => strlen($httpParams->data),
                                1                => 'one: two',
                               );
        $config              = array(
                                'cookieStore'    => 'cookies.txt',
                                'followLocation' => true,
                                'SSLVerifyHost'  => false,
                                'SSLVerifyPeer'  => false,
                                'verbose'        => false,
                                'returnTransfer' => true,
                               );
        $curlMock = $this->_setCurlExpectations($httpParams, $config);
        $this->object->prepareCurl($curlMock, $httpParams, $config);

    }//end testPrepareCurlWithMaximum()


    /**
     * Test the prepareCurl method without password
     *
     * @test
     *
     * @return void
     */
    public function testPrepareCurlWithoutPass()
    {
        $httpParams               = $this->_setUpHttpParamsFull();
        $httpParams->httpPassword = null;
        $curlMock = $this->_setCurlExpectations($httpParams);

        $this->object->prepareCurl($curlMock, $httpParams);

    }//end testPrepareCurlWithoutPass()


    /**
     * Test the prepareCurl method with invalid method
     *
     * @expectedException InvalidHttpMethodException
     * @test
     *
     * @return void
     */
    public function testPrepareCurlWithInvalidMethod()
    {
        $httpParams             = $this->_setUpHttpParamsFull();
        $httpParams->httpMethod = 'ivalidmethod';
        $curlMock               = $this->getMock('Curl');
        $this->object->prepareCurl($curlMock, $httpParams);

    }//end testPrepareCurlWithInvalidMethod()


    /**
     * Test the prepareCurl method with no url
     *
     * @expectedException NoUrlSetException
     * @test
     *
     * @return void
     */
    public function testPrepareCurlWithoutUrl()
    {
        $httpParams      = $this->_setUpHttpParamsFull();
        $httpParams->url = null;
        $curlMock        = $this->getMock('Curl');
        $this->object->prepareCurl($curlMock, $httpParams);

    }//end testPrepareCurlWithoutUrl()


}//end class

?>
