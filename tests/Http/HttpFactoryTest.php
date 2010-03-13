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
 * @version  GIT: $Id$
 * @link     http://www.assembla.com/spaces/p-pex
 */

require_once 'PHPUnit/Framework.php';

require_once dirname(__FILE__).'/../../src/Http/Http.php';
require_once dirname(__FILE__).'/../../src/Http/HttpFactory.php';

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
class HttpFactoryTest extends PHPUnit_Framework_TestCase
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
        $this->curlBuilderMock = $this->getMock('CurlBUilder');

        $this->object = new HttpFactory($this->curlBuilderMock);

    }//end setUp()


    /**
     * we need to ensure, that our object can't be created without it's
     * dependency
     *
     * @expectedException Exception
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
     * @return void()
     */
    public function testCreateHttp()
    {
        $actual = $this->object->createHttp();

        $this->assertTrue($actual instanceof Http);

    }//end testCreateHttp()


    /**
     * We'd like to ensure, that the correct initializer methods are called,
     * regardless to the order. The values are the keypoint.
     *
     * @return void
     */
    public function testSettingsInit()
    {
        $http = $this->object->createHttp();
        
        $this->assertAttributeEquals(
                'cookies.txt',
                '_cookieStore',
                $http,
                'setCookieStore was not called with cookies.txt argument');

        $this->assertAttributeEquals(
                false,
                '_SSLVerifyHost',
                $http,
                'verifySSL was not called with false');

        $this->assertAttributeEquals(
                false,
                '_SSLVerifyPeer',
                $http,
                'verifySSL was not called with false');

        $this->assertAttributeEquals(
                true,
                '_followLocation',
                $http,
                'followLocation was not called with true');
    }//end testSettingsInit()


}//end class

?>
