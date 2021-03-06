<?php
/**
 * StoreUrlDataTest.php
 *
 * Holds the Test for the StoreUrlData class
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
namespace Pex;
/**
 * The StoreUrlDataTest class is the unittest class for the StoreUrlData class
 *
 * PHP Version: 5
 *
 * @category Class
 * @package  Test
 * @author   meza <meza@meza.hu>
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 */
class StoreUrlDataTest extends PexTestBase
{


    /**
     * We'd like to be sure that the needed values are defined in the class
     *
     * @test
     *
     * @return void;
     */
    public function testThatValuesAreDefined()
    {
        if (false === class_exists(__NAMESPACE__.'\StoreUrlData')) {
            $this->fail('The required class is not loaded: StoreUrlData');
        }
        $this->assertClassHasAttribute('inbox', __NAMESPACE__.'\StoreUrlData');
        $this->assertClassHasAttribute('calendar', __NAMESPACE__.'\StoreUrlData');
        $this->assertClassHasAttribute('contacts', __NAMESPACE__.'\StoreUrlData');
        $this->assertClassHasAttribute('tasks', __NAMESPACE__.'\StoreUrlData');
        $this->assertClassHasAttribute('notes', __NAMESPACE__.'\StoreUrlData');

    }//end testThatValuesAreDefined()


}//end class

?>
