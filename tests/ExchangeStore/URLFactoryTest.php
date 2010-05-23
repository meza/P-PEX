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
    protected $testHost = 'https://www.example-server.com/';

    /**
     * @var URLAccess instance
     */
    protected $testURLAccess;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @return void
     */
    protected function setUp()
    {
        $this->testURLAccess = new URLAccess();
        $this->object        = new URLFactory(
            $this->testHost,
            $this->testUsername,
            $this->testURLAccess
        );

    }//end setUp()


    /**
     * We need to test that our object can't be created without it's
     * dependencies
     *
     * @expectedException Exception
     * @test
     * 
     * @return void
     */
    public function testNewWithoutAnyArguments()
    {
        $urlFactory = new URLFactory();

    }//end testNewWithoutAnyArguments()


    /**
     * We need to test that our object can't be created without it's
     * dependencies
     *
     * @expectedException Exception
     * @test
     *
     * @return void
     */
    public function testNewWithoutTheLastArguments()
    {
        $urlfactory = new URLFactory($this->testHost);

    }//end testNewWithoutTheLastArguments()


    /**
     * We want to be sure, that our factory only handles known types
     *
     * @test
     *
     * @return void
     */
    public function testGetUrlSchemeForUnknownType()
    {
        $expected = 'NotKnownTypeString';
        $actual   = $this->object->getUrlFor($expected);

        $this->assertEquals($expected, $actual);

    }//end testGetUrlSchemeForUnknownType()


    /**
     * We want to be able to request a login url too. This is made up as follows
     * <server_url>/exchweb/bin/auth/owaauth.dll
     *
     * @test
     *
     * @return void
     */
    public function testLoginUrlScheme()
    {
         $expected = $this->testHost.'/exchweb/bin/auth/owaauth.dll';
         $actual   = $this->object->getUrlFor(URLFactory::LOGIN);

         $this->assertEquals($expected, $actual);

    }//end testLoginUrlScheme()


     /**
      * We want to be able to request a referrer url
      *
      * @test
      *
      * @return void;
      */
    public function testReferrerUrlScheme()
    {
         $expected = $this->testHost.'/exchweb/bin/auth/owalogon.asp';
         $actual   = $this->object->getUrlFor(URLFactory::REFERRER);
         $this->assertEquals($expected, $actual);

    }//end testReferrerUrlScheme()


     /**
      * We need the user root
      *
      * @test
      *
      * @return void
      */
    public function testUserRootUrlScheme()
    {
         $expected = $this->testHost.'/exchange/'.$this->testUsername.'/';
         $actual   = $this->object->getUrlFor(URLFactory::USERROOT);
         $this->assertEquals($expected, $actual);

    }//end testUserRootUrlScheme()


    /**
     * We need an url for the contact
     *
     * @test
     *
     * @return void
     */
    public function testContactUrlScheme()
    {
        $this->testURLAccess->contacts = 'contacts';
        $contactName = 'testName';
        $expected = $this->testHost.'exchange/'.$this->testUsername.'/'.
                $this->testURLAccess->contacts.'/'.$contactName.'.eml';

        $actual = $this->object->getUrlFor(URLFactory::CONTACT, $contactName);

        $this->assertEquals($expected, $actual);


    }//end testContactUrlScheme()


}//end class

?>
