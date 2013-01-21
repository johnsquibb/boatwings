<?php

require_once __DIR__ . '/FrameworkTest.php';

use BoatWings\Loader\ClassLoader;
use BoatWings\Loader\Autoloader\Psr0Autoloader;

class LoaderTest extends PHPUnit_Framework_TestCase 
{
	public function testPsr0Autoloader()
	{
		$baseSearchDirectory = dirname(__DIR__);
		$autoloader = new Psr0Autoloader($baseSearchDirectory);
		$classLoader = new ClassLoader($autoloader);
		
		$classLoader->loadClass('BoatWings\Configuration\YamlConfigurationLoader');
		
		// Try to load the YAML configuration loader.
		$yamlConfigurationLoader = new BoatWings\Configuration\YamlConfigurationLoader(dirname(__DIR__));
	}
}