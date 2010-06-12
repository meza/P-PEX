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

    }//end anAnauthenticatedResponse()


}//end class

?>