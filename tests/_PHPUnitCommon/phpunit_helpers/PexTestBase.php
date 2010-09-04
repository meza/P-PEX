<?php
/**
 * PexTestBase.php
 *
 * Holds the PexTestBase class
 *
 * PHP Version: 5
 *
 * @category File
 * @package  Testhelper
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
namespace Pex;
/**
 * The PexTestBase class is responsible for tests
 *
 * PHP Version: 5
 *
 * @category Class
 * @package  Testhelper
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
class PexTestBase extends \MockAmendingTestCaseBase
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
     * Gets a 440 HttpResponse
     *
     * @return HttpResponse
     */
    protected function anUnauthenticatedResponse()
    {
        return $this->aResponse(440);

    }//end anUnauthenticatedResponse()


    /**
     * Gets a 400 not found response
     * 
     * @return HttpResponse
     */
    protected function aNotFoundResponse()
    {
        return $this->aResponse(404);

    }//end aNotFoundResponse()


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

        if (null !== $data) {
            $param->data = $data;
        }

        return $param;

    }//end anHttpParam()


    /**
     * Returns a login param
     * 
     * @param string $username The username to use
     * @param string $password The password to use
     * @param string $server   The server to login to
     * 
     * @return LoginHttpParams
     */
    protected function aLoginHttpParam($username='', $password='', $server='')
    {
        $param = new LoginHttpParams($username, $password, $server);

        return $param;

    }//end aLoginHttpParam()


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
        \MockObjectWrapper $http,
        HttpParams $params,
        $index=-1,
        HttpResponse $response=null
    ) {
        $this->assertType(
            __NAMESPACE__.'\Http',
            $http->mock,
            'Mock object should be a Http mock'
        );

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