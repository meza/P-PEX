<?php
/**
 * TaskCreateHttpParam.php
 *
 * Holds the TaskCreateHttpParam class
 *
 * PHP Version: 5
 *
 * @category File
 * @package  ExchangeStore
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

/**
 * The TaskCreateHttpParam class is the value object for Task creation
 *
 * PHP Version: 5
 *
 * @category Class
 * @package  ExchangeStore
 * @author   meza <meza@meza.hu>
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 */
class TaskCreateHttpParam extends HttpParams
{

    /**
     * @var string The root url
     */
    public $url = ExchangeStoreURLFactory::TASK;

    /**
     * @var array The headers to use for the request
     */
    public $headers = array(
                       'Content-Type' => 'text/xml',
                       'Depth'        => 0,
                       'Translate'    => 'f',
                      );

    /**
     * @var string The http method to use
     */
    public $httpMethod = 'post';

    /**
     * @var string The custom http method to use
     */
    public $customMethod = 'PROPPATCH';


    /**
     * Creates a task creator param object
     *
     * @param Task   $task     The Task to create
     * @param string $username The name of the user
     *
     * @return TaskCreateHttpParam
     */
    public function __construct(Task $task, $username)
    {
        $name            = $task->getFileAsName();
        $this->urlParams = array($this->_prepareName($name.$task->getUrlModifier()));
        $this->data      = '<?xml version="1.0"?>
<g:propertyupdate xmlns:g="DAV:"
    xmlns:e="http://schemas.microsoft.com/exchange/"
    xmlns:mapi="http://schemas.microsoft.com/mapi/"
    xmlns:cal="urn:schemas:calendar:"
    xmlns:dt="urn:uuid:c2f41010-65b3-11d1-a29f-00aa00c14882/"
    xmlns:f="http://schemas.microsoft.com/mapi/id/{00062002-0000-0000-C000-000000000046}/"
    xmlns:header="urn:schemas:mailheader:"
    xmlns:task="http://schemas.microsoft.com/exchange/tasks/"
    xmlns:mail="urn:schemas:httpmail:">
    <g:set>
        <g:prop>
            <g:contentclass>urn:content-classes:task</g:contentclass>
            <e:outlookmessageclass>IPM.Task</e:outlookmessageclass>
            <f:0x8214 dt:dt="int">4</f:0x8214>
            <mapi:finvited dt:dt="boolean">1</mapi:finvited>
            <cal:instancetype dt:dt="int">21</cal:instancetype>
            <e:x-priority-long dt:dt="int">'.$task->priority.'</e:x-priority-long>
            <cal:busystatus>BUSY</cal:busystatus>
            <cal:meetingstatus>CONFIRMED</cal:meetingstatus>
            <cal:alldayevent dt:dt="boolean">1</cal:alldayevent>
            <cal:responserequested dt:dt="boolean">1</cal:responserequested>
            <cal:reminderoffset dt:dt="int">900</cal:reminderoffset>
            <mail:subject>'.$task->subject.'</mail:subject>
            <mail:htmldescription>'.$task->description.'</mail:htmldescription>
            <cal:location>'.$task->location.'</cal:location>'.
            $this->getDate($task->getStartDate('c'), 'mapi:commonstart').
            $this->getDate($task->getEndDate('c'), 'mapi:commonend').
        '</g:prop>
    </g:set>
</g:propertyupdate>';

    }//end __construct()

    public function getDate($date, $tag)
    {
        
        if (false === empty($date)) {
            return '<'.$tag.'>'.$date.'</'.$tag.'>';
        }
        return '';
    }

    /**
     * Prepares the name for the url.
     * Performs an urlencode
     *
     * @param string $name The Task's name
     *
     * @return string
     */
    private function _prepareName($name)
    {
        return urlencode($name);

    }//end _prepareName()


}//end class

?>
