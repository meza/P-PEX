<?php
/**
 * CurlTest.php
 *
 * Holds the test class for the Curl class
 *
 * PHP Version: 5
 *
 * @category File
 * @package  HTTP
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

require_once dirname(__FILE__).'/../../src/Http/Curl.php';

/**
 * Testing 3rd party is not my goal. I only want to see that I set everything
 * correctly
 *
 * Test class for Curl.
 *
 * PHP Version: 5
 *
 * @category Test
 * @package  HTTP
 * @author   meza <meza@meza.hu>
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 *
 * @SuppressWarnings(PHPMD)
 */
class CurlTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var Curl
     */
    protected $object;

    /**
     * @var resource Internal curl pointer
     */
    protected $ch;

    /**
     * @var string The url to the test file
     */
    private $_testFile;


    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @return void
     */
    protected function setUp()
    {
        $this->object    = new Curl;
        $this->ch        = $this->readAttribute($this->object, '_ch');
        $this->_testFile = 'file://'.dirname(__FILE__).'/_files/curlExecuteTest.txt';

    }//end setUp()


    /**
     * Tests that the internal pointer is inited
     *
     * @test
     *
     * @return void
     */
    public function testConstruct()
    {
        $this->assertTrue(is_resource($this->ch));

    }//end testConstruct()


    /**
     * We want to ensure, that unwrutable path could not be set
     *
     * @expectedException InvalidCookieStoreException
     * @test
     *
     * @return void
     */
    public function testSetCookieStore()
    {
        $this->object->setCookieStore('/cookies.txt');

    }//end testSetCookieStore()


    /**
     * Feeds the test with the standard http methods
     *
     * @return array of arguments
     */
    public function setCustomMethodTestProvider()
    {
        return array(
                'get method'  => array('get'),
                'post method' => array('pOsT'),
               );

    }//end setCustomMethodTestProvider()


    /**
     * We need to ensure, that the setCustomMethod doesn't allow the standard
     * get/post methods
     *
     * @param string $method The http method to set
     * 
     * @dataProvider setCustomMethodTestProvider()
     * @expectedException InvalidCustomHttpMethodException
     * @test
     * 
     * @return void
     */
    public function testSetCustomMethod($method)
    {
        $this->object->setCustomMethod($method);

    }//end testSetCustomMethod()


    /**
     * The data provider for the formatData test
     *
     * @return array of arguments
     */
    public function formatDataTestProvider()
    {
        return array(
                'standard array'  => array(
                                      array(
                                       'var1' => 'val1',
                                       'var2' => 'val2',
                                       'var3' => 'val3',
                                      ),
                                      'var1=val1&var2=val2&var3=val3',
                                     ),
                'standard object' => array(
                             (object) array(
                                       'var1' => 'val1',
                                       'var2' => 'val2',
                                       'var3' => 'val3',
                                      ),
                                      'var1=val1&var2=val2&var3=val3',
                                     ),
                'null'            => array(
                                      null,
                                      '',
                                     ),
                'int 0'           => array(
                                      (int) 0,
                                      (string) 0,
                                     ),
               );

    }//end formatDataTestProvider()


    /**
     * Test that the formatData method creates the desired value
     *
     * @param mixed  $data     Could be an array or an object
     * @param string $expected The expected (query) string
     *
     * @dataProvider formatDataTestProvider()
     * @test
     *
     * @return void;
     */
    public function testFormatData($data, $expected)
    {
        $actual = $this->object->formatData($data);
        $this->assertSame($expected, $actual);

    }//end testFormatData()


    /**
     * Tests the getInfo method
     *
     * @test
     *
     * @return void
     */
    public function testGetInfo()
    {
        $expected = 'somedomain';
        curl_setopt($this->ch, CURLOPT_URL, $expected);

        $actual = $this->object->getInfo(CURLINFO_EFFECTIVE_URL);
        $this->assertEquals($expected, $actual);

        $actual = $this->object->getInfo();
        $this->assertEquals($expected, $actual['url']);

    }//end testGetInfo()


    /**
     * Tests the url setter
     *
     * @depends testGetInfo
     * @test
     *
     * @return void
     */
    public function testSetUrl()
    {
        $expected = 'somedomain2';

        $this->object->setUrl($expected);
        $actual = $this->object->getInfo(CURLINFO_EFFECTIVE_URL);
        $this->assertEquals($expected, $actual);

    }//end testSetUrl()


    /**
     * We need to test that the setData really set's the data
     * 
     * @test
     *
     * @return false
     */
    public function testSetData()
    {
        $expected = 'this is the data';
        $this->object->setData($expected);

        $this->assertAttributeEquals($expected, '_data', $this->object);

    }//end testSetData()


    /**
     * We need to ensure, that the setAuth can't be called without params
     *
     * @expectedException Exception
     * @test
     *
     * @return void
     */
    public function testSetAuthWithoutParams()
    {
        $this->object->setAuth();

    }//end testSetAuthWithoutParams()


    /**
     * We need to ensure, that the setAuth can't be called without pass
     *
     * @expectedException Exception
     * @test
     *
     * @return void
     */
    public function testSetAuthWithoutPass()
    {
        $this->object->setAuth('username');

    }//end testSetAuthWithoutPass()


    /**
     * We need to ensure, that the setHeaders can't be called with a non-array
     *
     * @expectedException Exception
     * @test
     *
     * @return void
     */
    public function testSetHeadersWithNonArray()
    {
        $this->object->setHeaders('username');

    }//end testSetHeadersWithNonArray()


    /**
     * Methods below this line are only for validating, that none of the
     * curl calls below throw an exception
     */


    /**
     * Prepares and calls an execute
     *
     * @param Curl   $object The object to use
     * @param string $url    The url to call
     * @param vool   $isPost Flag
     *
     * @return string response
     */
    private function _runExecute(Curl $object, $url, $isPost=false)
    {
        $object->setPost($isPost);
        $object->setReferrer(true);
        $object->setUrl($url);
        return $object->execute();

    }//end _runExecute()


    /**
     * Test execute with a normal get
     *
     * @test
     *
     * @return void
     */
    public function testExecute()
    {
        $expected = array(
                     'code' => 0,
                     'data' => 'this should be the returned message',
                    );
        $actual   = $this->_runExecute($this->object, $this->_testFile, false);
        $this->assertSame($expected, $actual);

    }//end testExecute()


    /**
     * Test execute with a normal post
     *
     * @test
     *
     * @return void
     */
    public function testExecute2()
    {
        $expected = array(
                     'code' => 0,
                     'data' => 'this should be the returned message',
                    );
        $actual   = $this->_runExecute($this->object, $this->_testFile, true);
        $this->assertSame($expected, $actual);

    }//end testExecute2()


    /**
     * Test execute with a normal get with data
     *
     * @test
     *
     * @return void
     *
     * @throws Exception if an unwanted exception is thrown
     */
    public function testExecute3()
    {
        $path = dirname(__FILE__).'/_files/curlExecuteTest.txt';
        $file = 'file://'.$path;
        $data = 'somedata';
        $this->object->setData($data);
        try {
            $this->_runExecute($this->object, $file, false);
            $this->fail('No url not found exception was raised');
        } catch (Exception $e) {
            if ($e->getMessage() === 'Couldn\'t open file '.$path.'?'.$data) {
                return;
            }

            throw $e;
        }

    }//end testExecute3()


    /**
     * We need to cover the following methods
     *
     * @test
     *
     * @return void
     */
    public function testCoverUntestableMethods()
    {
        $this->object->verbose();
        $this->object->verbose(true);
        $this->object->verbose(false);

        $this->object->followLocation();
        $this->object->followLocation(false);
        $this->object->followLocation(true);

        $this->object->setReferrer('http://www.google.com');
        $this->object->setReferrer();

        $this->object->returnHeaders();
        $this->object->returnHeaders(true);
        $this->object->returnHeaders(false);

        $this->object->setSSLVerifyPeer();
        $this->object->setSSLVerifyPeer(true);
        $this->object->setSSLVerifyPeer(false);

        $this->object->setSSLVerifyHost();
        $this->object->setSSLVerifyHost(true);
        $this->object->setSSLVerifyHost(false);

        $this->object->setHeaders(array());

        $this->object->setAuth('username', 'password', CURLAUTH_BASIC);

        $this->object->setCustomMethod('SEARCH');

        $this->object->setCookieStore('cookies.txt');

    }//end testCoverUntestableMethods()


}//end class

?>
