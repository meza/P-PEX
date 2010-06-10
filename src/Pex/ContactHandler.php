<?php
/**
 * ContactHandler.php
 *
 * File description
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
 *
 * @link     http://www.assembla.com/spaces/p-pex
 */

/**
 * The main interface of the contact handling api
 *
 * @category Interface
 * @package  Pex
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
interface ContactHandler
{


    /**
     * Creates a new contact in the exchange store
     *
     * @param Contact $contact The contact to save
     *
     * @return string The url of the newly created contact
     */
    public function createContact(Contact $contact);


    /**
     * List the contacts
     *
     * @return Contact
     */
    public function listContacts();


    /**
     * Update the given url to the given contact info
     *
     * @param string  $url     The url to update
     * @param Contact $contact The new information
     *
     * @return bool true on success, false otherwise
     */
    public function updateContact($url, Contact $contact);


    /**
     * Delete the contact on the given endpoint
     *
     * @param Contact $contact the Contact to delete
     *
     * @return bool
     */
    public function deleteContact(Contact $contact);


}//end interface

?>
