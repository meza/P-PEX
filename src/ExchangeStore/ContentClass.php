<?php
/**
 * ContentClass.php
 *
 * Holds the ContentClass class
 *
 * PHP Version: 5
 *
 * @category File
 * @package  ExchangeStore
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
 * The ContentClass class is the wrapper of content class constraints
 *
 * PHP Version: 5
 *
 * @category Class
 * @package  ExchangeStore
 * @author   meza <meza@meza.hu>
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 */
class ContentClass
{

    const APPOINTMENT      = 'urn:content-classes:appointment';
    const CALENDARFOLDER   = 'urn:content-classes:calendarfolder';
    const CALENDARMESSAGE  = 'urn:content-classes:calendarmessage';
    const CONTACTFOLDER    = 'urn:content-classes:contactfolder';
    const CONTACTCLASSDEF  = 'urn:content-classes:contentclassdef';
    const DOCUMENT         = 'urn:content-classes:document';
    const DSN              = 'urn:content-classes:dsn';
    const FOLDER           = 'urn:content-classes:folder';
    const FREEBUSY         = 'urn:content-classes:freebusy';
    const ITEM             = 'urn:content-classes:item';
    const JOURNALFOLDER    = 'urn:content-classes:journalfolder';
    const MAILFOLDER       = 'urn:content-classes:mailfolder';
    const MDN              = 'urn:content-classes:mdn';
    const MESSAGE          = 'urn:content-classes:message';
    const NOTESFOLDER      = 'urn:content-classes:notesfolder';
    const OBJECT           = 'urn:content-classes:object';
    const PERSON           = 'urn:content-classes:person';
    const PROPERTYDEF      = 'urn:content-classes:propertydef';
    const PROPERTYOVERRIDE = 'urn:content-classes:propertyoverride';
    const RECALLMESSAGE    = 'urn:content-classes:recallmessage';
    const RECALLREPORT     = 'urn:content-classes:recallreport';
    const TASKFOLDER       = 'urn:content-classes:taskfolder';
    const XMLDATA          = 'urn:schemas-microsoft-com:xml-data#ElementType';

}//end class

?>
