<?php
/**
 * ContentClass.php
 *
 * Holds the ContentClass class's test class
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
require_once dirname(__FILE__).'/../../src/ExchangeStore/ContentClass.php';

/**
 * The ContentClassTest class
 *
 * PHP Version: 5
 *
 * @category Class
 * @package  Test
 * @author   meza <meza@meza.hu>
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 */
class ContentClassTest extends PHPUnit_Framework_TestCase {

    /**
     * Data provider for a test. Returns all constants with their expected
     * values.
     *
     * @return array of test function arguments
     */
    public function provider()
    {
        return array(

            array(
                ContentClass::APPOINTMENT,
                'urn:content-classes:appointment'
            ),
            array(
                ContentClass::CALENDARFOLDER,
                'urn:content-classes:calendarfolder'
            ),
            array(
                ContentClass::CALENDARMESSAGE,
                'urn:content-classes:calendarmessage'
            ),
            array(
                ContentClass::CONTACTFOLDER,
                'urn:content-classes:contactfolder'
            ),
            array(
                ContentClass::CONTACTCLASSDEF,
                'urn:content-classes:contentclassdef'
            ),
            array(
                ContentClass::DOCUMENT,
                'urn:content-classes:document'
            ),
            array(
                ContentClass::DSN,
                'urn:content-classes:dsn'
            ),
            array(
                ContentClass::FOLDER,
                'urn:content-classes:folder'
            ),
            array(
                ContentClass::FREEBUSY,
                'urn:content-classes:freebusy'
            ),
            array(
                ContentClass::ITEM,
                'urn:content-classes:item'
            ),
            array(
                ContentClass::JOURNALFOLDER,
                'urn:content-classes:journalfolder'
            ),
            array(
                ContentClass::MAILFOLDER,
                'urn:content-classes:mailfolder'
            ),
            array(
                ContentClass::MDN,
                'urn:content-classes:mdn'
            ),
            array(
                ContentClass::MESSAGE,
                'urn:content-classes:message'
            ),
            array(
                ContentClass::NOTESFOLDER,
                'urn:content-classes:notesfolder'
            ),
            array(
                ContentClass::OBJECT,
                'urn:content-classes:object'
            ),
            array(
                ContentClass::PERSON,
                'urn:content-classes:person'
            ),
            array(
                ContentClass::PROPERTYDEF,
                'urn:content-classes:propertydef'
            ),
            array(
                ContentClass::PROPERTYOVERRIDE,
                'urn:content-classes:propertyoverride'
            ),
            array(
                ContentClass::RECALLMESSAGE,
                'urn:content-classes:recallmessage'
            ),
            array(
                ContentClass::RECALLREPORT,
                'urn:content-classes:recallreport'
            ),
            array(
                ContentClass::TASKFOLDER,
                'urn:content-classes:taskfolder'
            ),
            array(
                ContentClass::XMLDATA,
                'urn:schemas-microsoft-com:xml-data#ElementType'
            ),
        );

    }//end provider()


    /**
     * Verifies that all constants are correct
     *
     * @dataProvider provider()
     *
     * @return void
     */
    public function testThatTheConstantsAreProperlySet($actual, $expected)
    {
        $this->assertEquals($expected, $actual);
        
    }//end testThatTheConstantsAreProperlySet()

}//end class

?>
