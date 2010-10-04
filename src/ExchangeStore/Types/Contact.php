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
 //namespace Pex\ExchangeStore\Types;
namespace Pex;
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
     * Legal type.
     */
    CONST TYPE_LEGAL = 0;

    /**
     * Natural type.
     */
    CONST TYPE_NATURAL = 1;

    /**
     * @var string first name
     */
    public $firstName = '';

    /**
     * @var string middle name
     */
    public $middleName = '';

    /**
     * @var string last bame
     */
    public $lastName = '';

    /**
     * @var string Nickname
     */
    public $nickName = '';

    /**
     * @var string Company name
     */
    public $companyName = '';

    /**
     * @var string Email address
     */
    public $emailAddress = '';

    /**
     * @var string StorageUrlModifier
     */
    private $_urlModifier = '';

    /**
     * @var string url
     */
    public $url;

    /**
     * @var int type
     */
    private $_type = self::TYPE_NATURAL;


    /**
     * Creates a null object of a contact
     * 
     * @return Contact
     */
    public static function aContact()
    {
        $contact = new Contact();
        return $contact;

    }//end aContact()


    /**
     * Returns the "file as" format
     *
     * @return string
     */
    public function getFileAsName()
    {
        if (self::TYPE_NATURAL === $this->_type) {
            $nameParts = array(
                          $this->lastName,
                          $this->middleName,
                          $this->firstName,
                         );
        } else {
            $nameParts = array($this->companyName);
        }
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


    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setType($type)
    {
        switch($type) {
            case self::TYPE_NATURAL:
                $this->_type = $type;
                break;
            case self::TYPE_LEGAL;
                $this->_type = $type;
                break;
            default:
                throw new Exception('unsupported contact type');
        }
    }

}//end class

?>
