<?php
/**
 * Contact.php
 *
 * Holds the Contact type
 *
 * PHP Version: 5
 *
 * @category File
 * @package  Types
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
 * The Contact type
 *
 * PHP Version: 5
 *
 * @category Class
 * @package  Types
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
class Contact
{

    /**
     * @var string first name
     */
    public $firstName;

    /**
     * @var string middle name
     */
    public $middleName;

    /**
     * @var string last bame
     */
    public $lastName;

    /**
     * @var string Nickname
     */
    public $nickName;

    /**
     * @var string Email address
     */
    public $emailAddress;

    /**
     * @var string Organization
     */
    public $organization;


    /**
     * Creates a null object of a contact
     * 
     * @return Contact
     */
    public static function aContact()
    {
        return new Contact();

    }//end aContact()


    /**
     * Returns the "file as" format
     *
     * @return string
     */
    public function getFileAsName()
    {
        $nameParts = array(
                      $this->lastName,
                      $this->middleName,
                      $this->firstName,
                     );
        return implode(' ', $nameParts);

    }//end getFileAsName()


}//end class

?>
