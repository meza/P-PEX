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
require_once 'ContactHandler.php';
require_once 'CalendarHandler.php';
require_once 'TaskHandler.php';

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
class Pex implements PPexInterface, ContactHandler, CalendarHandler, TaskHandler
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
     * Tests a given string that it is a valid xml or not
     *
     * @param string $xmlString The xml to test
     *
     * @return bool
     */
    public function isValidXml($xmlString)
    {
        try {
            libxml_use_internal_errors(true);
            $xml = new SimpleXMLElement($xmlString);
            return true;
        } catch (Exception $e) {
            return false;
        }

    }//end isValidXml()


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
     * @throws Exception
     */
    public function call(HttpParams $params, $tries=0, $maxTries=1)
    {
        if (true === is_string($params->data)) {
            if (false === $this->isValidXml($params->data)) {
                throw new Exception(
                    'String could not be parsed as XML: '.get_class($params).'::data'
                );
            }
        }

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
            sleep(1);
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


    /**
     * Make the call to the server
     *
     * @param HttpParams $params     The http parameters
     * @param string     $parserType The parser type to parse the response with
     *
     * @return HttpResponse
     */
    private function _doCall(HttpParams $params, $parserType)
    {
        $result = $this->call($params);
        $parser = $this->parserFactory->createParser($parserType);
        return $this->parse($result->data, $parser);

    }//end _doCall()


    /**
     * Creates a new contact in the exchange store
     *
     * @param Contact $contact The contact to save
     *
     * @return string The url of the newly created contact
     */
    public function createContact(Contact $contact)
    {
        $param    = new ContactCheckHttpParam($contact);
        $response = $this->call($param);

        if ($response->code !== 404) {
            $contact->setUrlModifier(md5(date('c')));
            return $this->createContact($contact);
        }

        $params = new ContactCreateHttpParam($contact);
        $result = $this->_doCall($params, ParserFactory::CONTACT_CREATE);
        return $result;

    }//end createContact()


    /**
     * Retrieves the contact information from the given url
     *
     * @param string $url The endpoint
     *
     * @return Contact
     */
    public function readContact($url)
    {
        $params = new ContactGetHttpParams($url);
        $result = $this->_doCall($params, ParserFactory::CONTACT_GET);
        return $result;

    }//end readContact()


    public function updateContact($url, Contact $contact)
    {}

    public function deleteContact($url)
    {}




    /**
     * Creates an event in the store
     *
     * @param CalendarEvent $event The event to be stored
     *
     * @return bool
     */
    public function createEvent(CalendarEvent $event)
    {
        $params = new CalendarEventCreateHttpParam($event, $this->data->username);
        $result = $this->call($params);
        if (($result->code >= 200) && ($result->code < 300)) {
            return true;
        }

        return false;

    }//end createEvent()


    /**
     * Removes an entry from a given url
     *
     * @param CalendarEvent $event to delete
     *
     * @return bool True on success, false otherwise
     */
    public function deleteEvent(CalendarEvent $event)
    {
        $params = new CalendarEventDeleteHttpParams($event);
        $result = $this->call($params);

        if (($result->code >= 200) && ($result->code < 300)) {
            return true;
        }

        return false;

    }//end deleteEvent()


    /**
     * Lists al events in the exchange store
     *
     * @return CalendarEvent[]
     */
    public function listEvents()
    {
        $params = new CalendarEventListHttpParam();
        $result = $this->_doCall($params, ParserFactory::CALENDAR_EVENT_LIST);
        return $result;

    }//end listEvents()


    /**
     * Creates an event in the store
     *
     * @param Task $task The event to be stored
     *
     * @return string url of the newly created event
     */
    public function createTask(Task $task)
    {
        $params = new TaskCreateHttpParam($task, $this->data->username);
        $result = $this->call($params);
        if (($result->code >= 200) && ($result->code < 300)) {
            var_dump($params->data);
            return true;
        }
        var_dump($params->data ,$result);
        return false;

    }//end createTask()


    /**
     * Removes an entry from a given url
     *
     * @param Task $task to delete
     *
     * @return bool True on success, false otherwise
     */
    public function deleteTask(Task $task)
    {

    }//end deleteTask()


    /**
     * Lists al events in the exchange store
     *
     * @return Task[]
     */
    public function listTasks()
    {
        $params = new TaskListHttpParam();
        $result = $this->call($params);
        return $result;

    }//end listTasks()


}//end class

?>