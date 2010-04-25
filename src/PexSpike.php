<?php
/**
 * Pex.php
 *
 * File description with some dummy text
 *
 * PHP Version: 5
 *
 * @category File
 * @package  main
 *
 * @link     http://www.assembla.com/spaces/p-pex
 * @author   meza
 * @version  $Id$
 * @license GPL3.0
 *                    GNU GENERAL PUBLIC LICENSE
 *                       Version 3, 29 June 2007
 *
 * Copyright (C) 2007 Free Software Foundation, Inc. <http://fsf.org/>
 * Everyone is permitted to copy and distribute verbatim copies
 * of this license document, but changing it is not allowed.
 **/

require_once 'Http/Curl.php';
require_once 'Http/Http.php';
require_once 'Http/HttpFactory.php';
require_once 'Http/HttpParams.php';
require_once 'Http/CurlBuilder.php';
require_once 'ExchangeStore/URLFactory.php';
require_once 'ExchangeStore/HttpParams/LoginHttpParams.php';
require_once 'ExchangeStore/HttpParams/ServiceUrlsHttpParams.php';
require_once 'ExchangeStore/Parser/ParserFactory.php';
require_once 'Pex/ConnectionDataFactory.php';

class PexService
{

    /**
     * @var PexConnectionData
     */
    public $data;

    /**
     * @var URLFactory ojject;
     */
    public $urlFactory;

    /**
     * @var curlBuilder instance
     */
    public $curlBuilder;

    /**
     * @var httpFactory ojject
     */
    public $httpFactory;

    public function getHttp()
    {
        return $this->httpFactory->createHttp();
    }

    public function __construct(ConnectionData $data)
    {
        $this->data = $data;
        $this->urlFactory = new URLFactory($data->host, $data->username);
        $this->curlBuilder = new CurlBuilder($this->urlFactory);
        $this->httpFactory = new HttpFactory($this->curlBuilder);
    }
    public function getStoreUrls()
    {

        $params = new ServiceUrlsHttpParams();
        return $this->getHttp()->request($params);
    }

    function login()
    {
        $params = new LoginHttpParams(
            $this->data->username,
            $this->data->password,
            $this->data->host
        );
        $this->getHttp()->request($params);
    }
}

$df = new ConnectionDataFactory();
$fs = new PexService($df->createConnectionData('rokonai'));
$fs->login();
sleep(3);
$xml = $fs->getStoreUrls();
$pf = new ParserFactory();
$p = $pf->createParser(ParserFactory::STORE_URLS);
var_dump($p->parse($xml['data']));

?>

