<?php

namespace BoatWings\Loader\Autoloader;

/**
 * Autoloads classes in accordance with PSR-0.
 * https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md
 */
class Psr0Autoloader implements AutoloaderInterface
{
	/**
	 * Base directory to use when searching for class files using determined relative path.
	 * @var type 
	 */
	private $baseSearchDirectory;
	
	/**
	 * __construct.
	 * @param type $baseSearchDirectory
	 */
	public function __construct($baseSearchDirectory)
	{
		$this->baseSearchDirectory = $baseSearchDirectory;
	}
	
	/**
	 * Load class using modified version of example implementation from PSR-0 standard.
	 * @param type $className
	 */
	public function loadClass($className)
	{
		$className = ltrim($className, '\\');
		$filename = '';
		$namespace = '';
		if ($lastNsPos = strrpos($className, '\\'))
		{
			$namespace = substr($className, 0, $lastNsPos);
			$className = substr($className, $lastNsPos + 1);
			$filename = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
		}
		$filename .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
		
		$filepath = $this->baseSearchDirectory . DIRECTORY_SEPARATOR . $filename;		
		if (is_readable($filepath))
		{
			require_once $filepath;
		}
	}
}