<?php
/**
 * ContactFactory.php
 *
 * Holds the ContactFactory class
 *
 * PHP Version: 5
 *
 * @category File
 * @package  Testhelper
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

require_once dirname(__FILE__).'/../../src/ExchangeStore/Types/Contact.php';

/**
 * The ContactFactory class is responsible for creating contacts
 *
 * PHP Version: 5
 *
 * @category Class
 * @package  Testhepler
 * @author   meza
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 */
class ContactFactory
{
    
    public function createAValidContact()
    {
        $contact = Contact::aContact();
        $contact->emailAddress = 'a@a.aa';
        $contact->firstName    = 'firstnAme';
        $contact->lastName     = 'lastName';
        $contact->middleName   = 'mName';
        $contact->nickName     = 'nick';
        $contact->organization = 'org';

        return $contact;
    }


}//end class

?>
