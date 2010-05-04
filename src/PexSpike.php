<?php

require_once 'Http/Curl.php';
require_once 'Http/Http.php';
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

error_reporting(E_ALL | E_STRICT | E_DEPRECATED);
$df            = new ConnectionDataFactory('./config/');
$data          = $df->createConnectionData('rokonai');
$urlAccess     = new URLAccess();
$urlFactory    = new URLFactory($data->host, $data->username, $urlAccess);
$curlBuilder   = new CurlBuilder($urlFactory);
$httpFactory   = new HttpFactory($curlBuilder);
$parserFactory = new ParserFactory();

$fs = new Pex($data, $urlAccess, $httpFactory, $parserFactory);
$fs->login();

$contact = new Contact();
$contact->emailAddress = 'meza@meza.hu';
$contact->firstName    = 'Márton';
$contact->lastName     = 'Mészáros';
$contact->nickName     = 'meza';
$contact->organization = 'uStream Inc';

$params = new ContactCreateHttpParams($contact);
$x = $fs->call($params);
var_dump($x);
?>