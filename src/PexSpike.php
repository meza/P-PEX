<?php
require_once 'Pex/Pex.php';
require_once 'ExchangeStore/HttpParams/ContactCreateHttpParam.php';


$df            = new ConnectionDataFactory();
$data          = $df->createConnectionData('rokonai');
$urlAccess     = new URLAccess();
$urlFactory    = new URLFactory($data->host, $data->username, $urlAccess);
$curlBuilder   = new CurlBuilder($urlFactory);
$httpFactory   = new HttpFactory($curlBuilder);
$parserFactory = new ParserFactory();

$fs = new Pex($data, $urlAccess, $httpFactory, $parserFactory);
$fs->login();
$params = new ContactCreateHttpParams('JoLynnDobney');
$x = $fs->call($params);
var_dump($x);
?>