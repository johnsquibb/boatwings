<?php
namespace BoatWings\Loader;

use \BoatWings\Loader\Autoloader\AutoloaderInterface;

class ClassLoader
{
	/**
	 * Autoloader for class loading.
	 * @var AutoloaderInterface $autoloader
	 */
	private $autoLoader;
	
	public function __construct(AutoloaderInterface $autoloader)
	{
		$this->autoLoader = $autoloader;
	}
	
	/**
	 * Load class from autoloader.
	 * @param type $className
	 */
	public function loadClass($className)
	{
		$this->autoLoader->loadClass($className);
	}
}