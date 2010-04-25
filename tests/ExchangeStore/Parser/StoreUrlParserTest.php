<?php
/**
 * StoreUrlParserTest.php
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
 * @version  GIT: $Id$
 * @link     http://www.assembla.com/spaces/p-pex
 */

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__).'/../../../src/ExchangeStore/ExchangeResponse.php';
require_once dirname(__FILE__).'/../../../src/ExchangeStore/Parser/Parser.php';
require_once dirname(__FILE__).'/../../../src/ExchangeStore/Parser/Exceptions/NoSuchParserException.php';
require_once dirname(__FILE__).'/../../../src/ExchangeStore/Parser/StoreUrlData.php';
require_once dirname(__FILE__).'/../../../src/ExchangeStore/Parser/StoreUrlParser.php';

/**
 * The StoreUrlParserTest class is the unittest class for the StoreUrlParser class
 *
 * PHP Version: 5
 *
 * @category Class
 * @package  Test
 * @author   meza <meza@meza.hu>
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 */
class StoreUrlParserTest extends PHPUnit_Framework_TestCase
{

    private $_xmlString = '<?xml version="1.0"?>
 <a:multistatus xmlns:b="urn:uuid:c2f41010-65b3-11d1-a29f-00aa00c14882/"
 xmlns:d="urn:schemas:httpmail:" xmlns:a="DAV:">
  <a:response>
   <a:href>https://my.server.com/exchange/myusername/</a:href>
   <a:propstat>
    <a:status>HTTP/1.1 200 OK</a:status>
    <a:prop>
     <d:inbox>
      https://my.server.com/exchange/myusername/Be%C3%A9rkezett%20%C3%BCzenetek
     </d:inbox>
     <d:calendar>https://my.server.com/exchange/myusername/Napt%C3%A1r</d:calendar>
     <d:contacts>
      https://my.server.com/exchange/myusername/N%C3%A9vjegyalbum
     </d:contacts>
     <d:tasks>https://my.server.com/exchange/myusername/Feladatok</d:tasks>
     <d:notes>https://my.server.com/exchange/myusername/Feljegyz%C3%A9sek</d:notes>
    </a:prop>
   </a:propstat>
  </a:response>
 </a:multistatus>
';


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
        $expected           = new StoreUrlData();
        $expected->inbox    = 'Be%C3%A9rkezett%20%C3%BCzenetek';
        $expected->calendar = 'Napt%C3%A1r';
        $expected->contacts = 'N%C3%A9vjegyalbum';
        $expected->tasks    = 'Feladatok';
        $expected->notes    = 'Feljegyz%C3%A9sek';

        $parser = new StoreUrlParser();
        $actual = $parser->parse($this->_xmlString);

        $this->assertEquals($expected, $actual);

    }//end testParse()


}//end class

?>
