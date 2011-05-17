<?xml version="1.0" encoding="utf-8" ?>
<phpunit
	colors="false"
	syntaxCheck="true"
	convertErrorsToExceptions="true"
	convertNoticesToExceptions="true"
	convertWarningsToExceptions="true"
    bootstrap="tests/_PHPUnitCommon/conf/bootstrap.php"
	stopOnFailure="false">
    <filter>
        <whitelist>
            <directory suffix=".php">src/</directory>
            <exclude>
        	<file>src/PexSpike.php</file>
            </exclude>
        </whitelist>
    </filter>


    <php>
		<ini name="display_errors"   value="32767"      />
 	</php>



</phpunit>