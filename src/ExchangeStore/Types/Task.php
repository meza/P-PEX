<?php
/**
 * Task.php
 *
 * Holds the Task class
 *
 * PHP Version: 5
 *
 * @category File
 * @package  Task
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
 //namespace Pex\ExchangeStore\Types;
namespace Pex;
/**
 * The Task is the value object of all tasks
 *
 * PHP Version: 5
 *
 * @category Class
 * @package  Task
 * @author   meza <meza@meza.hu>
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 */
class Task
{

    /**
     * The default return date format
     */
    const DEFAULT_DATE_FORMAT = 'Y-m-d H:i';

    const PRIORITY_LOW    = 0;
    const PRIORITY_NORMAL = 1;
    const PRIORITY_HIGH   = 2;

    /**
     * @var string The ISO 8601 date format of the start date
     */
    public $start;

    /**
     * @var string The ISO 8601 date format of the end date
     */
    public $due;

    /**
     * @var string The subject of a task
     */
    public $subject;

    /**
     * @var string The location of the task
     */
    public $location;

    /**
     * @var string The description of the task
     */
    public $description;

    /**
     * @var string The url of the task
     */
    public $url;

    /**
     * @var string StorageUrlModifier
     */
    private $_urlModifier = '';


    public $priority = Task::PRIORITY_NORMAL;


    public function toArray()
    {
        return array(
            'start'       => $this->start,
            'due'         => $this->due,
            'subject'     => $this->subject,
            'location'    => $this->location,
            'description' => $this->description,
            'url'         => $this->url,
            'priority'    => $this->priority,
        );
    }


    /**
     * Null object constructor
     *
     * @param string $subject a task always needs a subject
     *
     * @return Task
     */
    public static function aTask($subject)
    {
        $object = new Task();
        $object->withSubject($subject);

        return $object;

    }//end aTask()


    /**
     * Null object constructor
     *
     * @param string $subject a task always needs a subject
     *
     * @return Task
     */
    public static function anUrgentTask($subject)
    {
        $object = new Task();
        $object->priority = Task::PRIORITY_HIGH;
        $object->withSubject($subject);

        return $object;

    }//end anUrgetnTask()


    /**
     * Null object constructor
     *
     * @param string $subject a task always needs a subject
     *
     * @return Task
     */
    public static function anUnimportantTask($subject)
    {
        $object = new Task();
        $object->priority = Task::PRIORITY_LOW;
        $object->withSubject($subject);

        return $object;

    }//end anUnimportantTask()


    /**
     * Set the start date of the task
     *
     * @param string $date The start date of the task
     *
     * @todo date format WTF
     *
     * @return Task
     */
    public function from($date)
    {
        $msFormat = '/[0-9]{4}-[0-9]{2}-[0-9]{2}T[0-9]{2}:[0-9]{2}:[0-9]{2}\s[0-9]{2}:[0-9]{2}/';
        if (0<preg_match($msFormat, $date)) {
            $date = str_replace(' ','+', $date);
        }
        $this->start = date('c', strtotime($date));
        return $this;

    }//end from()


    /**
     * Set the due date of a task
     *
     * @param string $date The due date of the task
     *
     * @todo date format WTF
     *
     * @return Task
     */
    public function due($date)
    {
        $msFormat = '/[0-9]{4}-[0-9]{2}-[0-9]{2}T[0-9]{2}:[0-9]{2}:[0-9]{2}\s[0-9]{2}:[0-9]{2}/';
        if (0<preg_match($msFormat, $date)) {
            $date = str_replace(' ','+', $date);
        }
        $this->due = date('c', strtotime($date));
        return $this;

    }//end due()


    /**
     * Set the location of the task
     *
     * @param string $location The location
     *
     * @return Task
     */
    public function at($location)
    {
        $this->location = $location;
        return $this;

    }//end at()


    /**
     * Set the description of the task
     *
     * @param string $description The description
     *
     * @return Task
     */
    public function withDescription($description)
    {
        $this->description = $description;
        return $this;

    }//end withDescription()


    /**
     * Set the subject of the task
     *
     * @param string $subject The subject
     *
     * @return Task
     */
    public function withSubject($subject)
    {
        $this->subject = $subject;
        return $this;

    }//end withSubject()


    /**
     * Set's the url parameter
     *
     * @param string $url The url
     *
     * @return void
     */
    public function setUrl($url)
    {
        $this->url = $url;

    }//end setUrl()


    /**
     * Returns the url of the current event
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;

    }//end getUrl()


    /**
     * Returns a date, formatted by format
     *
     * @param Date   $date   The date to format
     * @param string $format The formatter string
     *
     * @return string
     */
    private function _getDate($date, $format=self::DEFAULT_DATE_FORMAT)
    {
        return date($format, strtotime($date));

    }//end _getDate()


    /**
     * Returns the start date of the task, regarding the formatting
     *
     * @param string $format The format the date should be returned
     *
     * @return string
     */
    public function getStartDate($format=self::DEFAULT_DATE_FORMAT)
    {
        if (true === is_null($this->start)) {
            return '';
        }
        return $this->_getDate($this->start, $format);

    }//end getStartDate()


    /**
     * Returns the due date of the task, regarding the formatting
     *
     * @param string $format The format the date should be returned
     *
     * @return string
     */
    public function getDueDate($format=self::DEFAULT_DATE_FORMAT)
    {
        if (true === is_null($this->due)) {
            return '';
        }
        return $this->_getDate($this->due, $format);

    }//end getDueDate()


    /**
     * Returns the "file as" format
     *
     * @return string
     */
    public function getFileAsName()
    {
        $nameParts = array(
                      $this->subject,
                      $this->getStartDate('YmdHi'),
                     );
        $fileas =  implode(' ', $nameParts);

        return $fileas;

    }//end getFileAsName()


    /**
     * Returns the storage urlModifier if set
     *
     * @return string If the urlModifier is set, null otherwise
     */
    public function getUrlModifier()
    {
        return $this->_urlModifier;

    }//end getUrl()


    /**
     * Sets the storage urlModifier
     *
     * @param string $urlModifier The storage urlModifier
     *
     * @return void
     */
    public function setUrlModifier($urlModifier)
    {
        $this->_urlModifier = $urlModifier;

    }//end setUrl()

}//end class

?>
