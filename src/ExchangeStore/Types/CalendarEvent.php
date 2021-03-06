<?php
/**
 * CalendarEvent.php
 *
 * Holds the CalendarEvent class
 *
 * PHP Version: 5
 *
 * @category File
 * @package  Calendar
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
 //namespace Pex\ExchangeStore\Types;
namespace Pex;
/**
 * The CalendarEvent is the value object of all calendar events
 *
 * PHP Version: 5
 *
 * @category Class
 * @package  Calendar
 * @author   meza <meza@meza.hu>
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 */
class CalendarEvent
{

    /**
     * The default return date format
     */
    const DEFAULT_DATE_FORMAT = 'Y-m-d H:i';

    /**
     * @var string The ISO 8601 date format of the start date
     */
    public $start;

    /**
     * @var string The ISO 8601 date format of the end date
     */
    public $end;

    /**
     * @var string The subject of an event
     */
    public $subject;

    /**
     * @var string The location of the event
     */
    public $location;

    /**
     * @var string The description of the event
     */
    public $description;

    /**
     * @var string The url of the event
     */
    public $url;

    /**
     * @var string StorageUrlModifier
     */
    private $_urlModifier = '';


    public function toArray()
    {
        return array(
            'start'       => $this->start,
            'end'         => $this->end,
            'subject'     => $this->subject,
            'location'    => $this->location,
            'description' => $this->description,
            'url'         => $this->url,
        );
    }


    /**
     * Null object constructor
     *
     * @param string $subject An event always needs a subject
     *
     * @return CalendarEvent
     */
    public static function anEvent($subject)
    {
        $object = new CalendarEvent();
        $object->withSubject($subject);

        return $object;

    }//end anEvent()


    /**
     * Set the start date of the event
     *
     * @param string $date The start date of the event
     *
     * @return CalendarEvent
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
     * Set the end date of an event
     *
     * @param string $date The end date of the event
     *
     * @return CalendarEvent
     */
    public function to($date)
    {
        $msFormat = '/[0-9]{4}-[0-9]{2}-[0-9]{2}T[0-9]{2}:[0-9]{2}:[0-9]{2}\s[0-9]{2}:[0-9]{2}/';
        if (0<preg_match($msFormat, $date)) {
            $date = str_replace(' ','+', $date);
        }
        $this->end = date('c', strtotime($date));
        return $this;

    }//end to()


    /**
     * Set the location of the event
     *
     * @param string $location The location
     *
     * @return CalendarEvent
     */
    public function at($location)
    {
        $this->location = $location;
        return $this;

    }//end at()


    /**
     * Set the description of the event
     *
     * @param string $description The description
     *
     * @return CalendarEvent
     */
    public function withDescription($description)
    {
        $this->description = $description;
        return $this;

    }//end withDescription()


    /**
     * Set the subject of the event
     *
     * @param string $subject The subject
     *
     * @return CalendarEvent
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
     * Returns the start date of the event, regarding the formatting
     *
     * @param string $format The format the date should be returned
     *
     * @return string
     */
    public function getStartDate($format=self::DEFAULT_DATE_FORMAT)
    {
        return $this->_getDate($this->start, $format);

    }//end getStartDate()


    /**
     * Returns the end date of the event, regarding the formatting
     *
     * @param string $format The format the date should be returned
     *
     * @return string
     */
    public function getEndDate($format=self::DEFAULT_DATE_FORMAT)
    {
        return $this->_getDate($this->end, $format);

    }//end getEndDate()


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
