<?php
/**
 * TaskListParser.php
 *
 * Holds the TaskListParser class
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
 * The TaskListParser class is responsible for parsing the
 * list of tasks
 *
 * PHP Version: 5
 *
 * @category Class
 * @package  Parser
 * @author   meza <meza@meza.hu>
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 */
class TaskListParser implements Parser
{


    /**
     * Parses the xml
     *
     * @param string $xmlString The xml string to parse
     *
     * @return Task[]
     */
    public function parse($xmlString)
    {
        libxml_use_internal_errors(true);
        $xml = new \SimpleXMLElement($xmlString);
        $xml->registerXPathNamespace('dav', 'DAV:');
        $xml->registerXPathNamespace('d', 'urn:schemas:calendar:');
        $xml->registerXPathNamespace('e', 'urn:schemas:httpmail:');
        $xml->registerXPathNamespace('mapi', 'http://schemas.microsoft.com/mapi/');

        $tasks = $xml->xpath('//dav:propstat/*[text()=\'HTTP/1.1 200 OK\']/../dav:prop');
        if (false === $tasks) {
            return array();
        }

        $result = array();
        foreach ($tasks as $taskIndex => $taskValue) {
            $properties = $taskValue->xpath('*');
            $task       = new Task();

            foreach ($properties as $prop) {
                $this->_setUpTask($task, $prop);
            }

            $result[] = $task;
        }//end foreach

        return array_reverse($result);

    }//end parse()


    /**
     * Populates a reference to an task, with data regarding the property
     *
     * @param Task             $task       The task to populate
     * @param\SimpleXMLElement $xmlElement The property to consider
     *
     * @return void
     */
    private function _setUpTask(
        Task $task,
        \SimpleXMLElement $xmlElement
    ) {
        switch ($xmlElement->getName())
        {
        case 'href':
            $task->setUrl((string) $xmlElement);
            break;
        case 'commonstart':
            $task->from((string) $xmlElement);
            break;
        case 'commonend':
            $task->to((string) $xmlElement);
            break;
        case 'commondue':
            $task->due((string) $xmlElement);
            break;
        case 'location':
            $task->at((string) $xmlElement);
            break;
        case 'subject':
            $task->withSubject((string) $xmlElement);
            break;
        case 'textdescription':
            $task->withDescription((string) $xmlElement);
            break;
        case 'htmldescription':
            $task->withDescription((string) $xmlElement);
            break;
        }//end switch

    }//end _setUpTask()


}//end class

?>
