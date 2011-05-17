<?php
//die;
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
namespace Pex;
require_once 'Http/Curl.php';
require_once 'Http/Http.php';
require_once 'Http/HttpResponse.php';
require_once 'Http/HttpFactory.php';
require_once 'Http/HttpParams.php';
require_once 'Http/CurlBuilder.php';
require_once 'Http/URLFactory.php';
require_once 'Http/Exceptions/InvalidHttpMethodException.php';
require_once 'Http/Exceptions/NoUrlSetException.php';
require_once 'Http/Exceptions/InvalidCookieStoreException.php';
require_once 'Http/Exceptions/InvalidCustomHttpMethodException.php';
require_once 'ExchangeStore/Types/Contact.php';
require_once 'ExchangeStore/Types/Task.php';
require_once 'ExchangeStore/Types/CalendarEvent.php';
require_once 'ExchangeStore/URLAccess.php';
require_once 'ExchangeStore/ExchangeStoreURLFactory.php';
require_once 'ExchangeStore/ExchangeResponse.php';
require_once 'ExchangeStore/HttpParams/LoginHttpParams.php';
require_once 'ExchangeStore/HttpParams/ServiceUrlsHttpParams.php';
require_once 'ExchangeStore/Parser/Parser.php';
require_once 'ExchangeStore/Parser/CalendarEventListParser.php';
require_once 'ExchangeStore/Parser/StoreUrlData.php';
require_once 'ExchangeStore/Parser/ParserFactory.php';
require_once 'ExchangeStore/Parser/Exceptions/NoSuchParserException.php';
require_once 'Pex/PPexInterface.php';
require_once 'Pex/Pex.php';
require_once 'Pex/ConnectionData.php';
require_once 'Pex/ConnectionDataFactory.php';
require_once 'Pex/Exceptions/NoSuchConfigFileException.php';
require_once 'Pex/Exceptions/CouldNotLoginException.php';

require_once 'ExchangeStore/HttpParams/ContactCreateHttpParam.php';
require_once 'ExchangeStore/HttpParams/ContactDeleteHttpParam.php';
require_once 'ExchangeStore/HttpParams/ContactListHttpParam.php';
require_once 'ExchangeStore/HttpParams/ContactCheckHttpParam.php';
require_once 'ExchangeStore/HttpParams/CalendarEventListHttpParam.php';
require_once 'ExchangeStore/HttpParams/CalendarEventCreateHttpParam.php';
require_once 'ExchangeStore/HttpParams/CalendarEventDeleteHttpParam.php';
require_once 'ExchangeStore/HttpParams/TaskCreateHttpParam.php';
require_once 'ExchangeStore/HttpParams/TaskListHttpParam.php';
require_once 'ExchangeStore/HttpParams/TaskDeleteHttpParam.php';

error_reporting(E_ALL | E_STRICT | E_DEPRECATED);
$df            = new ConnectionDataFactory(realpath('./config/'));
$data          = $df->createConnectionData('rokonai');
$urlAccess     = new URLAccess();
$urlFactory    = new ExchangeStoreURLFactory($data->host, $data->username, $urlAccess);
$curlBuilder   = new CurlBuilder($urlFactory);
$httpFactory   = new HttpFactory($curlBuilder, HttpFactory::VERBOSE);
$parserFactory = new ParserFactory();

$fs = new Pex($data, $urlAccess, $httpFactory, $parserFactory);
login($fs);
sleep(1);
ini_set('xdebug.var_display_max_data', 2048);

$response  = $fs->listTasks();
var_dump($response);
die;
$resp = $fs->deleteTask($response[0]);
var_dump($resp);
$response  = $fs->listTasks();
var_dump($response);
die;

//$p = $parserFactory->createParser(ParserFactory::CALENDAR_EVENT_LIST);
//$d = $p->parse($response->data);
//var_dump($d);

header('Content-Type: text/xml');
print $response->data;


function login($fs)
{
    try {
        $fs->login();
    } catch (Exception $e)
    {
        if ("couldn't connect to host" === $e->getMessage()) {
            print "retry<br>";
            sleep(1);
            login($fs);
        }
    }
}
?>