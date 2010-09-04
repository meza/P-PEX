<?php
/**
 * TaskHandler.php
 *
 * Holds the TaskHandler interface
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
 * The TaskHandler interface declares the api for task handling
 *
 * PHP Version: 5
 *
 * @category Interface
 * @package  Pex
 * @author   meza <meza@meza.hu>
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 */
interface TaskHandler
{


    /**
     * Creates an event in the store
     *
     * @param Task $task The event to be stored
     *
     * @return string url of the newly created event
     */
    public function createTask(Task $task);


    /**
     * Removes an entry from a given url
     *
     * @param Task $task to delete
     *
     * @return bool True on success, false otherwise
     */
    public function deleteTask(Task $task);


    /**
     * Lists al events in the exchange store
     *
     * @return Task[]
     */
    public function listTasks();


}//end interface

?>
