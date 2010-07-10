<?php
/**
 * HttpClientRequestParser.php
 *
 * Holds the HttpClientRequestParser class
 *
 * PHP Version: PHP 5
 *
 * @category File
 * @package  Http
 * @author   meza <meza@meza.hu>
 * @license  GPL3.0
 *                    GNU GENERAL PUBLIC LICENSE
 *                       Version 3, 29 June 2007
 *
 * Copyright (C) 2007 Free Software Foundation, Inc. <http://fsf.org/>
 * Everyone is permitted to copy and distribute verbatim copies
 * of this license document, but changing it is not allowed.
 * @link     http://www.meza.hu
 */

/**
 * The HttpClientRequestParser class is responsible for parsing incoming
 * requests
 *
 * PHP Version: PHP 5
 *
 * @category Class
 * @package  Http
 * @author   meza <meza@meza.hu>
 * @license  GPL3.0
 *                    GNU GENERAL PUBLIC LICENSE
 *                       Version 3, 29 June 2007
 *
 * Copyright (C) 2007 Free Software Foundation, Inc. <http://fsf.org/>
 * Everyone is permitted to copy and distribute verbatim copies
 * of this license document, but changing it is not allowed.
 * @link     http://www.meza.hu
 */
class HttpClientRequestParser
{


    /**
     * Parses the request
     *
     * @param array  $scope       The scope of a request
     * @param string $inputStream The input stream url
     *
     * @return HttpClientRequest
     */
    public function parse($scope=null, $inputStream='php://input')
    {
        if (null === $scope) {
            $scope = $GLOBALS;
        }

        $req          = new HttpClientRequest();
        $req->method  = $scope['_SERVER']['REQUEST_METHOD'];
        $req->headers = new HttpHeaderComposite();

        foreach ($this->getHeaders() as $name => $value) {
            $header = new HttpHeader($name, $value);
            $req->headers->addItem($header);
        }

        $req->data = $this->getData($req->method, $scope, $inputStream);
        return $req;

    }//end parse()


    private function getData($method, $scope, $inputStream)
    {
        switch(strtolower($method)) {
        case 'delete':  return $this->getDeleteData($scope);
        case 'get':     return $this->getGetData($scope);
        case 'head':    return $this->getHeadData($scope);
        case 'options': return $this->getPostData($inputStream);
        case 'post':    return $this->getPostData($inputStream);
        case 'put':     return $this->getPostData($inputStream);
        }

    }//end getData()


    private function getGetData(array $scope)
    {
        return $scope['_GET'];
    }

    private function getPostData($inputStream)
    {
        $data = file_get_contents($inputStream);
        parse_str($data, $result);
        return $result;

    }

    private function getDeleteData(array $scope)
    {
        return $this->getGetData($scope);

    }

    private function getHeadData(array $scope)
    {
        return array();

    }

    private function getOptionsData(array $scope)
    {
        return $this->getPostData($scope);

    }

    private function getHeaders()
    {
        if (true === function_exists('getallheaders')) {
            return getallheaders();
        }
        return array();
    }


}//end class

?>