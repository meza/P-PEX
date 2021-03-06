<?php
/**
 * HttpFactoryTest.php
 *
 * Holds the test class for the HttpFactory class
 *
 * PHP Version: 5
 *
 * @category File
 * @package  Http
 * @author   meza <meza@meza.hu>
 * @license  GPL3.0
 *                    GNU GENERAL PUBLIC LICENSE
 *                       Version 3, 29 June 2007
 *
 * Copyright (C) 2007 Free Software Foundation, Inc. <http://fsf.org/>
 * Everyone is permitted to copy and distribute verbatim copies
 * of this license document, but changing it is not allowed.
 *
 * @link     http://www.assembla.com/spaces/p-pex
 */
namespace Pex;
/**
 * Test class for the HttpFactory class
 *
 * Test class for HttpFactory.
 *
 * PHP Version: 5
 *
 * @category Test
 * @package  HTTP
 * @author   meza <meza@meza.hu>
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 */
class HttpFactoryTest extends PexTestBase
{

    /**
     * @var HttpFactory The tested object
     */
    protected $object;

    /**
     * @var CurlBuilder mock
     */
    protected $curlBuilderMock;


    /**
     * SetUp method for the test cases
     *
     * @return voids
     */
    protected function setUp()
    {
        $this->curlBuilderMock = $this->mock('CurlBuilder');
        $this->object = new HttpFactory(
            $this->curlBuilderMock->mock,
            HttpFactory::NORMAL
        );

    }//end setUp()


    /**
     * we need to ensure, that our object can't be created without it's
     * dependency
     *
     * @expectedException Exception
     * @test
     *
     * @return void
     */
    public function testCreateObjectWithoutDependencies()
    {
        $http = new HttpFactory();

    }//end testCreateObjectWithoutDependencies()


    /**
     * We want our method, to return a Http object
     *
     * @test
     *
     * @return void()
     */
    public function testCreateDefaultHttp()
    {
        $actual = $this->object->createHttp();
        $this->assertTrue($actual instanceof Http);

    }//end testCreateDefaultHttp()


    /**
     * We'd like to ensure, that the correct initializer methods are called,
     * regardless to the order. The values are the keypoint.
     *
     * @test
     *
     * @return void
     */
    public function testDefaultSettingsInit()
    {
        $http = $this->object->createHttp();

        $this->assertAttributeEquals(
            'cookies.txt',
            '_cookieStore',
            $http,
            'setCookieStore was not called with cookies.txt argument'
        );

        $this->assertAttributeEquals(
            false,
            '_sslVerifyHost',
            $http,
            'verifySSL was not called with false'
        );

        $this->assertAttributeEquals(
            false,
            '_sslVerifyPeer',
            $http,
            'verifySSL was not called with false'
        );

        $this->assertAttributeEquals(
            true,
            '_followLocation',
            $http,
            'followLocation was not called with true'
        );

        $this->assertAttributeEquals(
            false,
            '_verbose',
            $http,
            'verbose was not set to false'
        );

    }//end testDefaultSettingsInit()


    /**
     * We want our method, to return a Http object
     *
     * @test
     *
     * @return void()
     */
    public function testCreateVerboseHttp()
    {
        $this->object = new HttpFactory(
            $this->curlBuilderMock->mock,
            HttpFactory::VERBOSE
        );
        $actual       = $this->object->createHttp();
        $this->assertTrue($actual instanceof Http);

    }//end testCreateVerboseHttp()


    /**
     * We'd like to ensure, that the correct initializer methods are called,
     * regardless to the order. The values are the keypoint.
     *
     * @test
     *
     * @return void
     */
    public function testVerboseSettingsInit()
    {
        $this->object = new HttpFactory(
            $this->curlBuilderMock->mock,
            HttpFactory::VERBOSE
        );
        $http = $this->object->createHttp();

        $this->assertAttributeEquals(
            'cookies.txt',
            '_cookieStore',
            $http,
            'setCookieStore was not called with cookies.txt argument'
        );

        $this->assertAttributeEquals(
            false,
            '_sslVerifyHost',
            $http,
            'verifySSL was not called with false'
        );

        $this->assertAttributeEquals(
            false,
            '_sslVerifyPeer',
            $http,
            'verifySSL was not called with false'
        );

        $this->assertAttributeEquals(
            true,
            '_followLocation',
            $http,
            'followLocation was not called with true'
        );

        $this->assertAttributeEquals(
            true,
            '_verbose',
            $http,
            'verbose was not set to true'
        );

    }//end testVerboseSettingsInit()

}//end class

?>
