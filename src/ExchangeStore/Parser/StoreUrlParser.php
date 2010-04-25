<?php
/**
 * StoreUrlParser.php
 *
 * Holds the StoreUrlParser class
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
 * *
 * @version  GIT: $Id$
 * @link     http://www.assembla.com/spaces/p-pex
 */

/**
 * The StoreUrlParser is a Parser implementation, and is responsible for parsing
 * the custom store urls given by the server
 *
 * PHP Version: 5
 *
 * @category Class
 * @package  Parser
 * @author   meza <meza@meza.hu>
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 */
class StoreUrlParser implements Parser
{


    /**
     * Parses the store url message, which has the following format:
     * <?xml version="1.0"?>
     * <a:multistatus xmlns:b="urn:uuid:c2f41010-65b3-11d1-a29f-00aa00c14882/"
     *      xmlns:d="urn:schemas:httpmail:" xmlns:c="xml:" xmlns:a="DAV:">
     *   <a:response>
     *     <a:href><server>/exchange/<user>/</a:href>
     *     <a:propstat>
     *       <a:status>HTTP/1.1 200 OK</a:status>
     *       <a:prop>
     *         <d:inbox><server>/exchange/<user>/<inbox_string></d:inbox>
     *         <d:calendar><server>/exchange/<user>/<calendar_string></d:calendar>
     *         <d:contacts><server>/exchange/<user>/<contacts_string></d:contacts>
     *         <d:tasks><server>/exchange/<user>/<tasks_string></d:tasks>
     *         <d:notes><server>/exchange/<user>/<notes_string></d:notes>
     *         </a:prop>
     *       </a:propstat>
     *     </a:response>
     *   </a:multistatus>
     *
     * @param string $xmlString The given XML string
     *
     * @return StoreUrlData value object
     */
    public function parse($xmlString)
    {
        /*
            TODO This should be fixed. SimpleXML Error handling depends on the
            environment.
        */

        libxml_use_internal_errors(true);
        $xml = new SimpleXMLElement($xmlString);
        $xml->registerXPathNamespace('dav', 'DAV:');
        $root = $xml->xpath('//dav:href');
        $xml->registerXPathNamespace('sud', 'urn:schemas:httpmail:');
        $urls  = $xml->xpath('//sud:*');
        $value = new StoreUrlData();
        foreach ($urls as $url) {
            $value->{$url->getName()} = str_replace($root, '', trim((string) $url));
        }

        return $value;

    }//end parse()


}//end class

?>
