<?php
namespace BoatWings\Configuration;

class YamlConfigurationLoader 
{
	/**
	 * Base directory for searching and loading configuration files from relative paths.
	 * @var type 
	 */
	private $baseDirectory;
	
	/**
	 * __construct.
	 * @param type $baseDirectory
	 */
	public function __construct($baseDirectory)
	{
		$this->setBaseConfigurationDirectory($baseDirectory);
	}
	
	/**
	 * Set base directory for loading configuration files.
	 * @param type $baseDirectory
	 */
	public function setBaseConfigurationDirectory($baseDirectory)
	{
		$this->baseDirectory = $baseDirectory;
	}
	
	/**
	 * Load configuration file from relative path.
	 * @param type $relativeConfigPath
	 * @return type
	 * @throws \Exception
	 */
	public function loadConfiguration($relativeConfigPath)
	{
		$configPath = $this->baseDirectory . DIRECTORY_SEPARATOR . $relativeConfigPath;
		
		if (file_exists($configPath))
		{
			if (is_readable($configPath))
			{
				$yaml = file_get_contents($configPath);
				return $yaml;
			}
			else
			{
				throw new \Exception("YAML file '{$configPath}' does not have the correct read permissions.");
			}
		}
		else
		{
			throw new \Exception("YAML file '{$configPath}' does not exist.");
		}
	}
}