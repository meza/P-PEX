<?php
/**
 * Pex.php
 *
 * File description with some dummy text
 *
 * PHP Version: 5
 *
 * @category File
 * @package  Pex
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

require_once 'PPexInterface.php';

/**
 * The Pex class is the main class
 *
 * PHP Version: 5
 *
 * @category Class
 * @package  Pex
 * @author   meza <meza@meza.hu>
 * @license  GPLv3 <http://www.gnu.org/licenses/>
 * @link     http://www.assembla.com/spaces/p-pex
 */
class Pex implements PPexInterface
{

    /**
     * @var URLAccess instance
     */
    public $urlAccess;

    /**
     * @var httpFactory object
     */
    public $httpFactory;

    /**
     * @var ParserFactory instance
     */
    public $parserFactory;


    /**
     * Constructs the object
     *
     * @param ConnectionData $data          The ConnectionData to use
     * @param URLAccess      $urlAccess     The URLAccess instance to use
     * @param HttpFactory    $httpFactory   The HttpFactory to use
     * @param ParserFactory  $parserFactory The ParserFactory to use
     *
     * @return Pex
     */
    public function __construct(
        ConnectionData $data,
        URLAccess $urlAccess,
        HttpFactory $httpFactory,
        ParserFactory $parserFactory
    ) {
        $this->data          = $data;
        $this->urlAccess     = $urlAccess;
        $this->httpFactory   = $httpFactory;
        $this->parserFactory = $parserFactory;

    }//end __construct()


    /**
     * Returns a Http instance
     *
     * @param HttpFactory $factory The HttpFactory instance to use
     *
     * @return Http
     */
    public function getHttp(HttpFactory $factory)
    {
        return $factory->createHttp();

    }//end getHttp()


    /**
     * Performs a http call with the given params
     *
     * @param HttpParams $params   The httpParams object to use
     * @param int        $tries    The number of request tries
     * @param int        $maxTries The maximum amount of retries
     *
     * @return string result
     *
     * @throws CouldNotLoginException
     */
    public function call(HttpParams $params, $tries=0, $maxTries=1)
    {
        $result = $this->getHttp($this->httpFactory)->request($params);
        $tries++;
        if (false === ($params instanceof LoginHttpParams)) {
            if ($result->code === 440) {
                $loginResult = $this->login();
                if (false === $loginResult) {
                    if ($tries <= $maxTries) {
                        return $this->call($params, $tries);
                    } else {
                        throw new CouldNotLoginException();
                    }
                } else {
                    return $this->call($params, $tries);
                }
            }
        }

        return $result;

    }//end call()


    /**
     * Parses a $resultString with the given $parser
     *
     * @param string $resultString The xml response
     * @param Parser $parser       The Parser to use
     *
     * @return ExchangeResponse
     */
    public function parse($resultString, Parser $parser)
    {
        return $parser->parse($resultString);

    }//end parse()


    /**
     * Performs a login with the given data
     *
     * @return bool True on success, false otherwise
     */
    public function login()
    {
        $params      = new LoginHttpParams(
            $this->data->username,
            $this->data->password,
            $this->data->host
        );
        $loginResult = $this->call($params);
        if ($loginResult->code === 200) {
            $this->getStoreUrls();
            return true;
        }

        return false;

    }//end login()


    /**
     * Retrieve the list of custom store urls
     *
     * @return StoreUrlData
     */
    public function getStoreUrls()
    {
        $params = new ServiceUrlsHttpParams();
        $result = $this->call($params);
        $parser = $this->parserFactory->createParser(ParserFactory::STORE_URLS);
        $data   = $this->parse($result->data, $parser);
        $this->urlAccess->setCustomUrls($data);
        return $data;

    }//end getStoreUrls()


}//end class

?>