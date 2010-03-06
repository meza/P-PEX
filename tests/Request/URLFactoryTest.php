<?php
/**
 * URLFactoryTest.php
 *
 * Holds the Test for the URLFactory class
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
 * @version  GIT: $Id$
 * @link     http://www.assembla.com/spaces/p-pex
 */


require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__).'/../../src/Request/URLFactory.php';

/**
 * The URLFactoryTest class is the unittest class for the URLFactory class
 *
 * PHP Version: 5
 *
 * @category Class
 * @package  Test
 * @author   meza <meza@meza.hu>
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 */
class URLFactoryTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var URLFactory The excerciesd object
     */
    protected $object;

    /**
     * @var string The dummy username to use
     */
    protected $testUsername = 'testuser';

    /**
     * @var string The dummy hostname to use
     */
    protected $testHost = 'https://www.example-server.com';


    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @return void
     */
    protected function setUp() {
        $this->object = new URLFactory($this->testHost, $this->testUsername);
    }


    /**
     * We need to test that our object can't be created without it's
     * dependencies
     *
     * @expectedException Exception
     *
     * @return void
     */
    public function testNewWithoutAnyArguments()
    {
        new URLFactory();

    }//end testNewWithoutAnyArguments()


    /**
     * We need to test that our object can't be created without it's
     * dependencies
     *
     * @expectedException Exception
     *
     * @return void
     */
    public function testNewWithoutTheLastArguments()
    {
        new URLFactory($this->testHost);

    }//end testNewWithoutTheLastArguments()


    /**
     * We want to be sure, that our factory only handles known types
     *
     * @expectedException Exception
     *
     * @return void
     */
    public function testGetUrlSchemeForUnknownType()
    {
        $this->object->getUrlFor('NotKnownTypeString');

    }//end testGetUrlSchemeForUnknownType()


    /**
     * We want our factory to be able to handle the inbox url.
     * The exchange server's inbox url scheme is made up as it follows:
     * <server_url>/Exchange/<username>/Inbox
     *
     * So we expect our code to return this scheme, when it is required
     */
    public function testInboxUrlScheme()
    {
        $expected = $this->testHost.'/Exchange/'.$this->testUsername.'/Inbox';
        $actual   = $this->object->getUrlFor(URLFactory::INBOX);

        $this->assertEquals($expected, $actual);

    }//end testInboxUrlScheme()


    /**
     * We want to be able to request a login url too. This is made up as follows
     * <server_url>/exchweb/bin/auth/owaauth.dll
     *
     * @return void
     */
     public function testLoginUrlScheme()
     {
         $expected = $this->testHost.'/exchweb/bin/auth/owaauth.dll';
         $actual   = $this->object->getUrlFor(URLFactory::LOGIN);

         $this->assertEquals($expected, $actual);
         
     }//end testLoginUrlScheme()


}//end class

?>
