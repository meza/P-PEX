<?php
/**
 * PexSpike.php
 *
 * The spike file
 *
 * PHP Version: 5
 *
 * @category File
 * @package  Spike
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
 **/

require_once 'Http/Curl.php';
require_once 'Http/Http.php';
require_once 'Http/HttpResponse.php';
require_once 'Http/HttpFactory.php';
require_once 'Http/HttpParams.php';
require_once 'Http/CurlBuilder.php';
require_once 'Http/Exceptions/InvalidHttpMethodException.php';
require_once 'Http/Exceptions/NoUrlSetException.php';
require_once 'Http/Exceptions/InvalidCookieStoreException.php';
require_once 'Http/Exceptions/InvalidCustomHttpMethodException.php';
require_once 'ExchangeStore/Types/Contact.php';
require_once 'ExchangeStore/URLAccess.php';
require_once 'ExchangeStore/URLFactory.php';
require_once 'ExchangeStore/ExchangeResponse.php';
require_once 'ExchangeStore/HttpParams/LoginHttpParams.php';
require_once 'ExchangeStore/HttpParams/ServiceUrlsHttpParams.php';
require_once 'ExchangeStore/Parser/Parser.php';
require_once 'ExchangeStore/Parser/StoreUrlData.php';
require_once 'ExchangeStore/Parser/ParserFactory.php';
require_once 'ExchangeStore/Parser/Exceptions/NoSuchParserException.php';
require_once 'Pex/Exceptions/NoSuchConfigFileException.php';
require_once 'Pex/Exceptions/CouldNotLoginException.php';
require_once 'Pex/ConnectionData.php';
require_once 'Pex/ConnectionDataFactory.php';
require_once 'Pex/PPexInterface.php';

require_once 'Pex/Pex.php';
require_once 'ExchangeStore/HttpParams/ContactCreateHttpParam.php';
require_once 'ExchangeStore/HttpParams/ContactUpdateHttpParam.php';
require_once 'ExchangeStore/HttpParams/ContactDeleteHttpParam.php';
require_once 'ExchangeStore/HttpParams/ContactGetHttpParam.php';

error_reporting(E_ALL | E_STRICT | E_DEPRECATED);
$df            = new ConnectionDataFactory(realpath('./config/'));
$data          = $df->createConnectionData('rokonai');
$urlAccess     = new URLAccess();
$urlFactory    = new URLFactory($data->host, $data->username, $urlAccess);
$curlBuilder   = new CurlBuilder($urlFactory);
$httpFactory   = new HttpFactory($curlBuilder);
$parserFactory = new ParserFactory();

$fs = new Pex($data, $urlAccess, $httpFactory, $parserFactory);
$fs->login();

$contact               = Contact::aContact();
$contact->emailAddress = 'reg@meza.hu';
$contact->firstName    = 'Márton2';
$contact->lastName     = 'Mészáros';
$contact->nickName     = 'meza';
$contact->organization = 'an org';

$x = new ContactGetHttpParams('https://mail.rokonai.hu/exchange/rokonaiintranet/N%C3%A9vjegyalbum/M%C3%A9sz%C3%A1ros%2B%2BM%C3%A1rton2.eml');
$xx = $fs->call($x);


//$res = $fs->createContact($contact);
//$xml = $res->data;
header('Content-Type: text/xml');
print $xx->data;
?>