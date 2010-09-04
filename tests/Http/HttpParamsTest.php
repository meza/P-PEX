<?php
/**
 * HttpParamsTest.php
 *
 * Holds the test cases for the HttpParams class
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
 * @link     http://www.assembla.com/spaces/p-pex
 **/
namespace Pex;
/**
 * The test class of the HttpParams class
 *
 * PHP Version: 5
 *
 * @category Class
 * @package  Test
 * @author   meza <meza@meza.hu>
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 */
class HttpParamsTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var HttpParams instance
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
        $this->object = new HttpParams();

    }//end setUp()


    /**
     * We need to make sure the preparedUrl is set
     *
     * @return void
     */
    public function testSetPreparedUrl()
    {
        $this->assertNull($this->object->preparedurl);
        $expected = "foo.bar";
        $this->object->setPreparedUrl($expected);
        $actual = $this->readAttribute($this->object, 'preparedUrl');
        $this->assertEquals($expected, $actual);

    }//end testSetPreparedUrl()


}//end class

?>
