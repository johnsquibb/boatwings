<?php

// Base directory of framework.
$baseDirectory = dirname(dirname(__DIR__));

// Operating System Directory separator.
$dirSep = DIRECTORY_SEPARATOR;

// BoatWings vendor directory.
$boatWingsDirectory = $baseDirectory . $dirSep . 'BoatWings';

// BoatWings Loader directory.
$boatWingsLoaderDirectory = $boatWingsDirectory . $dirSep . 'Loader';

// BoatWings Framework directory.
$boatWingsFrameworkDirectory = $boatWingsDirectory . $dirSep . 'Framework';

// BoatWings Service configuration directory.
$boatWingsServiceConfigDirectory = $boatWingsFrameworkDirectory . $dirSep . 'Config' . $dirSep . 'Services';

// Fetch Loader dependencies.
require_once $boatWingsLoaderDirectory . $dirSep . 'ClassLoader.php';
require_once $boatWingsLoaderDirectory . $dirSep . 'Autoloader' . $dirSep . 'AutoloaderInterface.php';
require_once $boatWingsLoaderDirectory . $dirSep . 'Autoloader' . $dirSep . 'Psr0Autoloader.php';

// Register PSR-0 compliant class autoloader.
$autoloader = new \BoatWings\Loader\Autoloader\Psr0Autoloader($baseDirectory);
$classLoader = new \BoatWings\Loader\ClassLoader($autoloader);
spl_autoload_register(array($classLoader, 'loadClass'));

// Ready the service factory wrapper.
$yamlConfigurationLoader = new \BoatWings\Configuration\YamlConfigurationLoader($boatWingsServiceConfigDirectory);
$yamlConfigurationParser = new \BoatWings\Configuration\YamlConfigurationParser();
$serviceFactory = new \BoatWings\Service\ServiceFactory($yamlConfigurationLoader, $yamlConfigurationParser);
\BoatWings\Service\ServiceFactoryWrapper::setServiceFactory($serviceFactory);

// Broadcast bootstrap complete.
const BOATWINGS_BOOTSTRAP_COMPLETE = TRUE;