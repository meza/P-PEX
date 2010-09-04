<?php
/**
 * Bootstrap file for PHPUnit tests
 *
 * PHP VERSION 5.2
 *
 * @category File
 * @package  Testhelper
 *
 * @author fqqdk <fqqdk@clusterone.hu>
 * @author meza <meza@meza.hu>
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
 * Encapsulates the bootstrapping logic
 *
 * @return void
 */
function __bootstrap()
{
	if (false == isset($GLOBALS['__testLevel'])) {
		print 'Defining E_TESTLEVEL as E_ALL | E_DEPRECATED | E_STRICT '.PHP_EOL;
		print 'You can use a phpunit.xml configuration file to override this' . PHP_EOL;
		$testErrorLevel = E_ALL | E_DEPRECATED | E_STRICT;
	} else {
		$testErrorLevel = $GLOBALS['__testLevel'];
	}

	/**
	 * @final the error_reporting level to use when test code runs.
	 *        this setting is only enforced by MockAmendingTestCaseBase
	 */
	define('E_TESTLEVEL', $testErrorLevel);

	if (false == isset($GLOBALS['__loaderLevel'])) {
		print 'Defining E_LOADERLEVEL as ' .
			'E_ALL &~ E_NOTICE &~ E_WARNING &~ E_DEPRECATED &~ E_STRICT ' . PHP_EOL;
		print 'You can use a phpunit.xml configuration file to override this' . PHP_EOL;
		$loadErrorLevel = E_ALL &~ E_NOTICE &~ E_DEPRECATED &~ E_STRICT;
	} else {
		$loadErrorLevel = $GLOBALS['__loaderLevel'];
	}

	/**
	 * @final the default error_reporting level that is used every other time
	 *        - in the class autoloaders
	 *        - when PHPUnit includes files for coverage report
	 *        - when PHPUnit includes the testcase classes
	 */
	define('E_LOADERLEVEL', $loadErrorLevel);
    chdir(dirname(__file__). '/../../../');
    
    $dirs = array(
        'src',
        'src/config',
        'src/Pex',
        'src/Pex/Exceptions',
        'src/ExchangeStore',
        'src/ExchangeStore/Parser',
        'src/ExchangeStore/Parser/Exceptions',
        'src/ExchangeStore/Types',
        'src/ExchangeStore/HttpParams',
        'src/Http',
        'src/Http/Exceptions',
        'tests',
        'tests/_HelperFiles',
        'tests/Pex',
        'tests/ExchangeStore',
        'tests/ExchangeStore/Parser',
        'tests/Http',
        'tests/Http/_files',
        'tests/_PHPUnitCommon',
        'tests/_PHPUnitCommon/conf',
        'tests/_PHPUnitCommon/conf/hudson',
        'tests/_PHPUnitCommon/phpunit_helpers',
        '.',
    );

    $path = implode(PATH_SEPARATOR, $dirs);
    set_include_path($path.PATH_SEPARATOR.get_include_path());

    require_once 'PHPUnit/Framework.php';
    require_once 'vfsStream/vfsStream.php';
    require_once 'MockAmendingTestCaseBase.php';

	
	error_reporting(E_LOADERLEVEL);
    spl_autoload_register();
    $f = spl_autoload_functions();
	spl_autoload_register($f[0]);
	spl_autoload_register(array(new \Autoloader, 'loadClass'));
}

class Autoloader
{
    public function loadClass($className)
    {
        echo __NAMESPACE__."\n";
        echo $className."\n";
        $pos = strrpos($className, '\\');
        $className = substr($className, $pos+1);
        echo $className."\n";
        require_once($className.'.php');
    }
}

__bootstrap();

?>