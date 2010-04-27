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
require_once dirname(__FILE__).'/../../src/Http/HttpFactory.php';
require_once dirname(__FILE__).'/../../src/Http/HttpParams.php';
require_once dirname(__FILE__).'/../../src/ExchangeStore/URLAccess.php';
require_once dirname(__FILE__).'/../../src/ExchangeStore/Parser/ParserFactory.php';
require_once dirname(__FILE__).'/../../src/ExchangeStore/HttpParams/LoginHttpParams.php';
require_once dirname(__FILE__).'/../../src/ExchangeStore/HttpParams/ServiceUrlsHttpParams.php';

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
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @return void
     */
    protected function setUp()
    {
        $this->object = new Pex;

    }//end setUp()


    /**
     * @todo Implement testGetHttp().
     */
    public function testGetHttp() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testCall().
     */
    public function testCall() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testParse().
     */
    public function testParse() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testLogin().
     */
    public function testLogin() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testGetStoreUrls().
     */
    public function testGetStoreUrls() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }


}//end class

?>
