<?php
/**
 * ContactCreateParserTest.php
 *
 * Holds the ContactCreateParserTest class
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
 * @link     http://www.assembla.com/spaces/p-pex
 */

/**
 * The ContactCreateParserTest class is responsible for ...
 *
 * PHP Version: 5
 *
 * @category Class
 * @package  Test
 * @author   meza <meza@meza.hu>
 * @license  GPL3.0
 *                    GNU GENERAL PUBLIC LICENSE
 *                       Version 3, 29 June 2007
 *
 * Copyright (C) 2007 Free Software Foundation, Inc. <http://fsf.org/>
 * Everyone is permitted to copy and distribute verbatim copies
 * of this license document, but changing it is not allowed.
 * @link     http://www.assembla.com/spaces/p-pex
 */
class ContactCreateParserTest extends PexTestBase
{


    /**
     * Check that the parser retrieves the url in a response
     *
     * @return void
     */
    public function testParse()
    {
        $url       = 'http://a.server.com/contactUrl.EML';
        $xmlString = '<?xml version="1.0"?>
<a:multistatus xmlns:a="DAV:"><a:response>
<a:href>'.$url.'</a:href>
</a:response></a:multistatus>';

        $parser = new ContactCreateParser();
        $actual = $parser->parse($xmlString);

        $this->assertEquals($url, $actual);

    }//end testParse()


}//end class

?>