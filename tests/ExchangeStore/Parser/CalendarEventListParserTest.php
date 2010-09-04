<?php
/**
 * CalendarEventListParserTest.php
 *
 * Holds the Test for the StoreUrlParser class
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
 * @link     http://www.assembla.com/spaces/p-pex
 */
namespace Pex;
/**
 * The CalendarEventListParserTest class is the unittest class for the
 * CalendarEventListParser class
 *
 * PHP Version: 5
 *
 * @category Class
 * @package  Test
 * @author   meza <meza@meza.hu>
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 */
class CalendarEventListParserTest extends PexTestBase
{

    /**
     * @var CalendarEventListParser instance
     */
    protected $object;

    /**
     * @var string the xml string
     */
    private $_xmlString = '<?xml version="1.0"?>
<a:multistatus xmlns:b="urn:uuid:c2f41010-65b3-11d1-a29f-00aa00c14882/"
xmlns:e="urn:schemas:httpmail:" xmlns:c="xml:" xmlns:d="urn:schemas:calendar:"
xmlns:a="DAV:"><a:response>
<a:href>https://mail.rokonai.hu/exchange/rokonaiintranet/Napt%C3%A1r/{8D717CCC-C399-4161-91F6-23D159322873}.EML</a:href>
<a:propstat><a:status>HTTP/1.1 200 OK</a:status><a:prop>
<a:href>https://mail.rokonai.hu/exchange/rokonaiintranet/Napt%C3%A1r/{8D717CCC-C399-4161-91F6-23D159322873}.EML</a:href>
<d:busystatus>BUSY</d:busystatus><e:subject>test event2</e:subject>
<e:textdescription>
test description2</e:textdescription>
<d:dtstart b:dt="dateTime.tz">2010-05-28T06:00:00.000Z</d:dtstart>
<d:dtend b:dt="dateTime.tz">2010-05-28T06:30:00.000Z</d:dtend>
<d:created b:dt="dateTime.tz">2010-05-23T16:06:54.000Z</d:created>
<d:duration b:dt="int">1800</d:duration><d:location>test location2</d:location>
</a:prop></a:propstat></a:response><a:response>
<a:href>https://mail.rokonai.hu/exchange/rokonaiintranet/Napt%C3%A1r/{5CD50F59-8DF2-4DB5-AFEA-34DB11A4BAB9}.EML</a:href>
<a:propstat><a:status>HTTP/1.1 200 OK</a:status><a:prop>
<a:href>https://mail.rokonai.hu/exchange/rokonaiintranet/Napt%C3%A1r/{5CD50F59-8DF2-4DB5-AFEA-34DB11A4BAB9}.EML</a:href>
<d:busystatus>BUSY</d:busystatus><e:subject>test event</e:subject>
<e:textdescription>test description</e:textdescription>
<d:dtstart b:dt="dateTime.tz">2010-05-26T06:00:00.000Z</d:dtstart>
<d:dtend b:dt="dateTime.tz">2010-05-26T06:30:00.000Z</d:dtend>
<d:created b:dt="dateTime.tz">2010-05-23T16:05:42.000Z</d:created>
<d:duration b:dt="int">1800</d:duration><d:location>test location</d:location>
</a:prop></a:propstat></a:response></a:multistatus>';


    /**
     * Sets up the fixtures
     *
     * @return void
     */
    public function setUp()
    {
        $this->object = new CalendarEventListParser();

    }//end setUp()


    /**
     * We'd like to see that the parser works right, and populates the valueObject as
     * expected
     *
     * @test
     *
     * @return void;
     */
    public function testParse()
    {
        $ev1 = CalendarEvent::anEvent(
            'test event'
        )->from(
            '2010-05-26T08:00:00+02:00'
        )->to(
            '2010-05-26T08:30:00+02:00'
        )->at('test location')->withDescription(
            'test description'
        );
        $ev1->setUrl('https://mail.rokonai.hu/exchange/rokonaiintranet/Napt%C3%A1r/{5CD50F59-8DF2-4DB5-AFEA-34DB11A4BAB9}.EML');

        $ev2 = CalendarEvent::anEvent(
            'test event2'
        )->from(
            '2010-05-28T08:00:00+02:00'
        )->to(
            '2010-05-28T08:30:00+02:00'
        )->at('test location2')->withDescription(
            "\ntest description2"
        );
        $ev2->setUrl('https://mail.rokonai.hu/exchange/rokonaiintranet/Napt%C3%A1r/{8D717CCC-C399-4161-91F6-23D159322873}.EML');

        $expected = array(
                     $ev1,
                     $ev2,
                    );
        $actual   = $this->object->parse($this->_xmlString);

        $this->assertEquals($expected, $actual);

    }//end testParse()


    /**
     * Test that we get an empty array, when no events are in the list
     *
     * @return void
     */
    public function testParseWithNoData()
    {
        $xmlString = '<?xml version="1.0"?>
<a:multistatus xmlns:b="urn:uuid:c2f41010-65b3-11d1-a29f-00aa00c14882/"
xmlns:e="urn:schemas:httpmail:" xmlns:c="xml:" xmlns:d="urn:schemas:calendar:"
xmlns:a="DAV:"></a:multistatus>';
        $expected  = array();
        $actual    = $this->object->parse($xmlString);

        $this->assertEquals($expected, $actual);

    }//end testParseWithNoData()


}//end class

?>
