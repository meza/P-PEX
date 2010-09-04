<?php
/**
 * CreateParser.php
 *
 * Holds the CreateParser class
 *
 * PHP Version: 5
 *
 * @category File
 * @package  Parser
 * @author   meza <meza@meza.hu>
 * @license  GPL3.0
 *                    GNU GENERAL PUBLIC LICENSE
 *                       Version 3, 29 June 2007
 *
 * Copyright (C) 2007 Free Software Foundation, Inc. <http://fsf.org/>
 * Everyone is permitted to copy and distribute verbatim copies
 * of this license document, but changing it is not allowed.
 *
 * @link     http://www.assembla.com/spaces/p-pex
 */
 //namespace Pex\ExchangeStore\Parser;
namespace Pex;
/**
 * The CreateParser class is responsible for ...
 *
 * PHP Version: 5
 *
 * @category Class
 * @package  Parser
 * @author   meza <meza@meza.hu>
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 */
class CreateParser implements Parser
{


    /**
     * Parses the xml
     *
     * @param string $xmlString The xml string to parse
     *
     * @return string The url the  was created at
     */
    public function parse($xmlString)
    {
        libxml_use_internal_errors(true);
        $xml = new \SimpleXMLElement($xmlString);
        $xml->registerXPathNamespace('dav', 'DAV:');
        $root = $xml->xpath('//dav:href');

        return basename((string) $root[0]);

    }//end parse()


}//end class

?>
