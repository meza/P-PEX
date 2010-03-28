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


class PexConnectionData
{
	public $uAgent = "User-Agent: Mozilla/5.0 (X11; U; Linux x86_64; hu-HU; rv:1.9.1.8) Gecko/20100214 Ubuntu/9.10 (karmic) Firefox/3.5.8";
	public $exchange_server;
	public $exchange_username;
	public $exchange_password;
}

class ConnectionDataFactory
{

    /**
     * Returns a connection data
     * @param <type> $connectionId
     */
    public function createConnectionData($connectionId, $section=null)
    {
        $confName = strtolower((string) $connectionId);
        $file = 'config/'.$confName.'.ini';

        if (false === file_exists($file)) {
            throw new Exception('No such config file');
        }

        $config = parse_ini_file($file, true);

        if (null !== $section)
        {
            if (false === isset($config[$section])) {
                throw new Exception('No such config section');
            }
            $data = $config[$section];
        }

        $data = $config[$confName];

        $connData = new PexConnectionData();
        $connData->exchange_server = $data['server'];
        $connData->exchange_username = $data['username'];
        $connData->exchange_password = $data['password'];

        return $connData;
    }
}


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

    public function __construct(PexConnectionData $data)
    {
        $this->data = $data;
        $this->urlFactory = new URLFactory($data->exchange_server, $data->exchange_username);
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
            $this->data->exchange_username,
            $this->data->exchange_password,
            $this->data->exchange_server
        );
        $this->getHttp()->request($params);
    }
}

//$df = new ConnectionDataFactory();
//$fs = new PexService($df->createConnectionData('rokonai'));
//$fs->login();
//sleep(3);
//$xml = $fs->getStoreUrls();
//$pf = new ParserFactory();
//$p = $pf->createParser(ParserFactory::STORE_URLS);
//var_dump($p->parse($xml['data']));

?>

