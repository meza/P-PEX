<?php
/**
 * PPexInterface.php
 *
 * Holds the api definition of ppex
 *
 * PHP version: 5.2
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
 * @version  GIT: $ID$
 * @link     http://www.assembla.com/spaces/p-pex
 */

/**
 * The main interface of the P-Pex Api
 *
 * @category Interface
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
 */
interface PPexInterface
{


    /**
     * Returns a Http instance
     *
     * @param HttpFactory $factory The HttpFactory instance to use
     *
     * @return Http
     */
    public function getHttp(HttpFactory $factory);


    /**
     * Performs a login with the given data
     *
     * @return bool True on success, false otherwise
     */
    public function login();


    /**
     * Performs a http call with the given params
     *
     * @param HttpParams $params   The httpParams object to use
     * @param int        $tries    The number of request tries
     * @param int        $maxTries The maximum amount of retries
     *
     * @return string result
     */
    public function call(HttpParams $params, $tries=0, $maxTries=1);


    /**
     * Parses a $resultString with the given $parser
     *
     * @param string $resultString The xml response
     * @param Parser $parser       The Parser to use
     *
     * @return ExchangeResponse
     */
    public function parse($resultString, Parser $parser);


    /**
     * Retrieve the list of custom store urls
     *
     * @return StoreUrlData
     */
    public function getStoreUrls();


}//end interface

?>
