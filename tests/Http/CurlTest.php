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
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @return void
     */
    protected function setUp()
    {
        $this->object = new Curl;
        $this->ch     = $this->readAttribute($this->object, '_ch');

    }//end setUp()


    /**
     * Tests that the internal pointer is inited
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
               );

    }//end formatDataTestProvider()


    /**
     * Test that the formatData method creates the desired value
     *
     * @param mixed  $data Could be an array or an object
     * @param string $expected  The expected (query) string
     *
     * @dataProvider formatDataTestProvider()
     *
     * @return void;
     */
    public function testFormatData($data, $expected)
    {
        $actual = $this->object->formatData($data);
        $this->assertEquals($expected, $actual);

    }//end testFormatData()


    /**
     * Tests the getInfo method
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
     * Methods below this line are only for validating, that none of the
     * curl calls below throw an exception
     */


}//end class

?>
