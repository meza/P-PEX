<?php
/**
 * ConnectionDataFactory.php
 *
 * Holds the connection factory class
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
 * The connection factory
 *
 * @category Class
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
class ConnectionDataFactory
{

    /**
     * @var string The root of the config file search
     */
    private $_configRoot = null;


    /**
     * Constructs the object
     *
     * @param string $configRoot The root of the config
     *
     * @return ConnectionDataFactory
     */
    public function  __construct($configRoot='.')
    {
        $this->_configRoot = realpath($configRoot);

    }//end __construct()


    /**
     * Returns a connection data
     *
     * @param string $connectionId The stored connection's id
     * @param string $section      Use a specified $section from the config
     *
     * @return ConnectionData
     *
     * @throws NoSuchConfigFileException    when a config file is not found
     * @throws NoSuchConfigSectionException when a config section is not found
     */
    public function createConnectionData($connectionId, $section=null)
    {
        $confName = strtolower((string) $connectionId);
        $file     = $this->_getConfigFileName($confName);

        if (false === file_exists($file)) {
            throw new NoSuchConfigFileException($file);
        }

        if (null === $section) {
            $section = $confName;
        }

        $config = parse_ini_file($file, true);

        if (false === isset($config[$section])) {
            throw new NoSuchConfigSectionException($section);
        }

        $data               = $config[$section];
        $connData           = new ConnectionData();
        $connData->host     = $data['server'];
        $connData->username = $data['username'];
        $connData->password = $data['password'];

        return $connData;

    }//end createConnectionData()


    /**
     * Returns the config file's name
     *
     * @param string $configName The config name
     *
     * @return string
     */
    private function _getConfigFileName($configName)
    {
        return $this->_configRoot.DIRECTORY_SEPARATOR.$configName.'.ini';

    }//end _getConfigFileName()


}//end class

?>
