<?php
/**
 * URLAccess.php
 *
 * Stores info about the custom urls
 *
 * PHP version: 5.2
 *
 * @category File
 * @package  ExchangeStore
 *
 * @author   meza <meza@meza.hu>
 * @license  GPL3.0
 *                    GNU GENERAL PUBLIC LICENSE
 *                       Version 3, 29 June 2007
 *
 * Copyright (C) 2007 Free Software Foundation, Inc. <http://fsf.org/>
 * Everyone is permitted to copy and distribute verbatim copies
 * of this license document, but changing it is not allowed.
 * @link     http://www.assembla.com/spaces/p-pex
 */

/**
 * The layer between the serice and the url factory
 *
 * @category Class
 * @package  ExchangeStore
 *
 * @author   meza <meza@meza.hu>
 * @license  GPL3.0
 *                    GNU GENERAL PUBLIC LICENSE
 *                       Version 3, 29 June 2007
 *
 * Copyright (C) 2007 Free Software Foundation, Inc. <http://fsf.org/>
 * Everyone is permitted to copy and distribute verbatim copies
 * of this license document, but changing it is not allowed.
 * @link     http://www.assembla.com/spaces/p-pex
 */
class URLAccess
{

    /**
     * @var string url
     */
    public $inbox;

    /**
     * @var string url
     */
    public $calendar;

    /**
     * @var string url
     */
    public $contacts;

    /**
     * @var string url
     */
    public $notes;

    /**
     * @var string url
     */
    public $tasks;


    /**
     * Parse a StoreUrlData object
     * 
     * @param StoreUrlData $urls The retrieved urls
     *
     * @return void
     */
    public function setCustomUrls(StoreUrlData $urls)
    {
        $this->inbox    = $urls->inbox;
        $this->calendar = $urls->calendar;
        $this->contacts = $urls->contacts;
        $this->notes    = $urls->notes;
        $this->tasks    = $urls->tasks;

    }//end setCustomUrls()


}//end class

?>
