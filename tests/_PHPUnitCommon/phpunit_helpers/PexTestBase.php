<?php
/**
 * PexTestBase.php
 *
 * Holds the PexTestBase class
 *
 * PHP Version: 5
 *
 * @category File
 * @package
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

/**
 * The PexTestBase class is responsible for tests
 *
 * PHP Version: 5
 *
 * @category Class
 * @package
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
class PexTestBase extends MockAmendingTestCaseBase
{


    /**
     * Return a response
     *
     * @param int    $code The http response code
     * @param string $data The http data
     *
     * @return HttpResponse
     */
    protected function aResponse($code=200, $data='demo result')
    {
        $response       = new HttpResponse();
        $response->code = $code;
        $response->data = $data;

        return $response;

    }//end aResponse()


    /**
     * Get a response with 200 ok
     *
     * @param string $data Custom data to return
     *
     * @return HttpResponse
     */
    protected function anOKResponse($data='an OK response')
    {
        return $this->aResponse(200, $data);

    }//end anOKResponse()


    /**
     * Gices
     * @return <type>
     */
    protected function anUnauthenticatedResponse()
    {
        return $this->aResponse(440);

    }//end anUnauthenticatedResponse()


    /**
     * Gets an empty HttpParams
     *
     * @param string $data The HttpParams's data
     *
     * @return HttpParams
     */
    protected function anHttpParam($data=null)
    {
        $param = new HttpParams();

        if (null !== $data)
        {
            $param->data = $data;
        }

        return $param;

    }//end anHttpParam()


    /**
     * Expect a http request
     *
     * @param MockObjectWrapper $http     The mock Http object
     * @param HttpParams        $params   The request HttpParams
     * @param int               $index    The index of the call (-1 for any)
     * @param HttpResponse      $response The wanted response
     *
     * @return Http
     */
    protected function expectRequest(
        MockObjectWrapper $http,
        HttpParams $params,
        $index=-1,
        HttpResponse $response=null
    ) {
        if ($index === -1) {
            $mock = $http->expects($this->any());
        } else {
            $mock = $http->expects($this->at($index));
        }

        $mock = $mock->method('request')->with(
            $this->equalTo($params)
        );

        if (null === $response) {
            $mock = $mock->will($this->returnValue($this->aResponse()));
        } else {
            $mock = $mock->will($this->returnValue($response));
        }

        return $http->mock;

    }//end expectRequest()


}//end class

?>