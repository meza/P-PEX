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
     */
    protected function setUp()
    {
        $this->object = new Curl;
        $this->ch = $this->readAttribute($this->object, '_ch');
    }


    /**
     * Tests that the internal pointer is inited
     */
    public function testConstruct()
    {
        $this->assertTrue(is_resource($this->ch));
    }

    public function testGetInfo()
    {
        $expected = 'somedomain';
        curl_setopt($this->ch, CURLOPT_URL, $expected);

        $actual = $this->object->getInfo(CURLINFO_EFFECTIVE_URL);
        $this->assertEquals($expected, $actual);

        $actual = $this->object->getInfo();
        $this->assertEquals($expected, $actual['url']);

    }

    /**
     * @depends testGetInfo
     */
    public function testSetUrl()
    {
        $expected = 'somedomain2';

        $this->object->setUrl($expected);
        $actual = $this->object->getInfo(CURLINFO_EFFECTIVE_URL);
        $this->assertEquals($expected, $actual);

    }

    

    public function testSetSSLVerifyPeer()
    {
        $this->object->setSSLVerifyPeer();
    }

    public function testSetSSLVerifyHost()
    {
        $this->object->setSSLVerifyHost();
    }

    public function testSetReturnTransfer()
    {
        $this->object->setReturnTransfer();
    }

    public function testSetPost()
    {
        $this->object->setPost();
    }

    public function testSetPostFields()
    {
        $this->object->setPostFields('');
        $this->object->setPostFields(array('a'=>'b'));
        $this->object->setPostFields((object) array('a'=>'b'));
    }

    public function testCallGet()
    {
        $this->object->setReturnTransfer(true);
        $this->object->call('www.meza.hu');
    }

    public function testCallGetUrl()
    {
        $expected = 'meza.hu?a=b&c=d';
        $this->object->setReturnTransfer(true);
        $this->object->call('meza.hu',(object) array(
            'a'=>'b',
            'c'=>'d'
        ));
        $actual = $this->object->getInfo();
        $this->assertEquals('http://'.$expected, $actual['url']);
    }

    public function testCallPost()
    {
        $this->object->setReturnTransfer(true);
        $this->object->call('www.meza.hu','',true);
    }

    /**
     * @expectedException Exception
     */
    public function testForMalformedUrl()
    {
        $this->object->call('somedomain');
    }

    public function testSetVerbose()
    {
        $this->object->verbose(false);
    }

    /**
     * @expectedException Exception
     */
    public function testSetCookieStoreError()
    {
        $this->object->setCookieStore('/root/nonexisting/cookies.txt');
    }


    public function testSetReferrer()
    {
        $this->object->setReferrer('value');
    }

    /**
     * @expectedException Exception
     */
    public function testSetMethodWithGet()
    {
        $this->object->setMethod('get');
    }


    /**
     * @expectedException Exception
     */
    public function testSetMethodWithPost()
    {
        $this->object->setMethod('post');
    }

    public function testSetMethodWith()
    {
        $this->object->setMethod('SEARCH');
    }

    public function testSetAuth()
    {
        $this->object->setAuth('user', 'pass');
    }

    /**
     * @expectedException Exception
     */
    public function testSetHeadersWithInvalidArg()
    {
        $this->object->setHeaders('Header-Name: header content');
    }

    public function testSetHeaders()
    {
        $this->object->setHeaders(array('Header-Name: header content'));
    }
}
?>
