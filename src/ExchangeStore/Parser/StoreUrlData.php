<?php
/**
 * StoreUrlData.php
 *
 * Holds the StoreUrlData class
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
 * The StoreUrlData is the valueobject holding the data
 * 
 * @TODO document
 *
 * PHP Version: 5
 *
 * @category Class
 * @package  Parser
 * @author   meza <meza@meza.hu>
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 */
class StoreUrlData implements ExchangeResponse
{

    /**
     * @var string Inbox url
     */
    public $inbox;

    /**
     * @var string Calendar url
     */
    public $calendar;

    /**
     * @var string Contacts url
     */
    public $contacts;

    /**
     * @var string Tasks url
     */
    public $tasks;

    /**
     * @var string Notes url
     */
    public $notes;

}//end class

?>
