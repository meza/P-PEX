<?php
/**
 * ContactHandlerTest.php
 *
 * Holds the ContactHandlerTest class
 *
 * PHP Version: 5
 *
 * @category File
 * @package  Test
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
 * The ContactHandlerTest class is responsible for ...
 *
 * PHP Version: 5
 *
 * @category Class
 * @package  Test
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
class ContactHandlerTest extends PexTest
{


    /**
     * Sets up the tests
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();
        $this->setUpHttpFactory(-1);

    }//end setUp()


    /**
     * Test that the correct calls are made for contact creation
     *
     * @return void
     */
    public function testCreateContact()
    {
        $createParams = new ContactCreateHttpParam($this->_aDummyContact());
        $checkParams  = new ContactCheckHttpParam($this->_aDummyContact());
        $response     = 'a dummy response';
        $url          = 'http://somedomain.com/dummy.eml';

        $this->expectRequest(
            $this->httpMock,
            $checkParams,
            0,
            $this->aNotFoundResponse()
        );

        $this->expectRequest(
            $this->httpMock,
            $createParams,
            1,
            $this->anOKResponse($response)
        );

        $this->parserFactoryMock->expects($this->once())->method(
            'createParser'
        )->with($this->equalTo(ParserFactory::CONTACT_CREATE))->will(
            $this->returnValue($this->parserMock->mock)
        );

        $this->parserMock->expects($this->once())->method('parse')->with(
            $this->equalTo($response)
        )->will($this->returnValue(md5(basename($url))));

        $actual = $this->object->createContact($this->_aDummyContact());
        $expected = md5(basename($url));

        $this->assertEquals(
            $expected,
            $actual
        );

    }//end testCreateContact()


    /**
     * Test that the correct calls are made for contact creation, when a contact
     * on the fileAs url exists
     *
     * @return void
     */
    public function testCreateContactWhenAlreadyExists()
    {
        $checkParamsA = new ContactCheckHttpParam($this->_aDummyContact());
        $contactB     = $this->_aDummyContact();
        $contactB->setUrlModifier(md5(date('Y-m-d H:i')));

        $checkParamsB = new ContactCheckHttpParam($contactB);
        $createParams = new ContactCreateHttpParam($contactB);
        $response     = 'a dummy response';

        $this->expectRequest($this->httpMock, $checkParamsA, 0);

        $this->expectRequest(
            $this->httpMock,
            $checkParamsB,
            1,
            $this->aNotFoundResponse()
        );

        $this->expectRequest(
            $this->httpMock,
            $createParams,
            2,
            $this->anOKResponse($response)
        );

        $this->parserFactoryMock->expects($this->once())->method(
            'createParser'
        )->with($this->equalTo(ParserFactory::CONTACT_CREATE))->will(
            $this->returnValue($this->parserMock->mock)
        );

        $this->parserMock->expects($this->once())->method('parse')->with(
            $this->equalTo($response)
        )->will($this->returnValue('dummy'));

        $actual   = $this->object->createContact($this->_aDummyContact());
        $expected = 'dummy';
        $this->assertEquals(
            $expected,
            $actual
        );



    }//end testCreateContactWhenAlreadyExists()


    /**
     * Test that contact listing works
     *
     * @return void
     */
    public function testListContacts()
    {
        $params   = new ContactListHttpParam();
        $response = 'A dummy response';

        $this->expectRequest(
            $this->httpMock,
            $params,
            0,
            $this->anOKResponse($response)
        );

        $this->parserFactoryMock->expects($this->once())->method(
            'createParser'
        )->with($this->equalTo(ParserFactory::CONTACT_LIST))->will(
            $this->returnValue($this->parserMock->mock)
        );

        $this->parserMock->expects($this->once())->method('parse')->with(
            $this->equalTo($response)
        )->will($this->returnValue('dummy'));

        $this->object->listContacts();

    }//end testListContacts()


    /**
     * Test that contact update works
     *
     * @return void
     */
    public function testUpdateContact()
    {
        $url            = 'some/url';
        $contactWithUrl = $this->_aDummyContact();
        $response       = 'dummy resp';
        $contactWithUrl->setUrl($url);

        $params      = new ContactCreateHttpParam($this->_aDummyContact());
        $params->url = $url;

        $this->expectRequest(
            $this->httpMock,
            $params,
            0,
            $this->anOKResponse($response)
        );

        $this->parserFactoryMock->expects($this->once())->method(
            'createParser'
        )->with($this->equalTo(ParserFactory::CONTACT_CREATE))->will(
            $this->returnValue($this->parserMock->mock)
        );

        $this->parserMock->expects($this->once())->method('parse')->with(
            $this->equalTo($response)
        )->will($this->returnValue('dummy'));

        $this->object->updateContact($contactWithUrl);

    }//end testUpdateContact()


    /**
     * Test that the right delete calls are made
     *
     * @return void
     */
    public function testDeleteContact()
    {
        $params = new ContactDeleteHttpParam($this->_aDummyContact());
        $this->expectRequest($this->httpMock, $params, 0);

        $actual = $this->object->deleteContact($this->_aDummyContact());
        $this->assertTrue($actual);

    }//end testDeleteContact()


    /**
     * Test that the right delete calls are made, but doesn't succeed
     *
     * @return void
     */
    public function testDeleteContactFailure()
    {
        $params = new ContactDeleteHttpParam($this->_aDummyContact());
        $this->expectRequest(
            $this->httpMock,
            $params,
            0,
            $this->aNotFoundResponse()
        );

        $actual = $this->object->deleteContact($this->_aDummyContact());
        $this->assertFalse($actual);

    }//end testDeleteContactFailure()


    /**
     * Generates a dummy contact
     *
     * @return Contact
     */
    private function _aDummyContact()
    {
        $contact = Contact::aContact();
        $contact->firstName = 'test';
        $contact->lastName  = 'name';

        return $contact;

    }//end _aDummyContact()


}//end class

?>