<?php
/**
 * CalendarHandler.php
 *
 * Holds the CalendarHandler interface
 *
 * PHP Version: 5
 *
 * @category File
 * @package  Pex
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
//namespace Pex;
namespace Pex;
/**
 * The CalendarHandler interface declares the api for calendar handling
 *
 * PHP Version: 5
 *
 * @category Interface
 * @package  Pex
 * @author   meza <meza@meza.hu>
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 */
interface CalendarHandler
{


    /**
     * Creates an event in the store
     *
     * @param CalendarEvent $event The event to be stored
     *
     * @return string url of the newly created event
     */
    public function createEvent(CalendarEvent $event);


    /**
     * Update a event
     *
     * @param CalendarEvemt $event The event to update
     *
     * @return HttpResponse
     */
    public function updateEvent(CalendarEvent $event);


    /**
     * Removes an entry from a given url
     *
     * @param CalendarEvent $event to delete
     *
     * @return bool True on success, false otherwise
     */
    public function deleteEvent(CalendarEvent $event);


    /**
     * Lists al events in the exchange store
     *
     * @return CalendarEvent[]
     */
    public function listEvents();


}//end interface

?>
