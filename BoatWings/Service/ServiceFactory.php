<?php
namespace BoatWings\Service;

use BoatWings\Configuration\YamlConfigurationLoader;
use BoatWings\Configuration\YamlConfigurationParser;

class ServiceFactory
{	
	private $loader;
	private $parser;
	
	/**
	 * __construct.
	 * @param \Configuration\YamlConfigurationLoader $loader
	 * @param \Configuration\YamlConfigurationParser $parser
	 */
	public function __construct(
		YamlConfigurationLoader $loader, 
		YamlConfigurationParser $parser
	)
	{
		$this->loader = $loader;
		$this->parser = $parser;
	}
	
	/**
	 * Load a service object.
	 * @param type $serviceName
	 * @return type
	 */
	public function getService($serviceName)
	{
		$relativeConfigPath = $serviceName . '.yml';
		$yaml = $this->loader->loadConfiguration($relativeConfigPath);
		
		$service = NULL;
		if ($yaml !== NULL)
		{
			$config = $this->parser->parseYaml($yaml);
			if (is_array($config))
			{
				$service = $this->buildService($config);
			}
		}
		
		return $service;
	}
	
	/**
	 * Build a service object.
	 * @param array $config
	 * @return type
	 */
	private function buildService(array $config)
	{
		$className = isset($config['class']) ? $config['class'] : NULL;
		$constructParamsConfig = isset($config['constructParams']) ? $config['constructParams'] : array();
	
		$service = NULL;
		if (isset($className))
		{
			$class = new \ReflectionClass($className);
			
			if ( ! empty($constructParamsConfig))
			{	
				$constructParams = $this->buildConstructParams($constructParamsConfig);
				$service = $class->newInstanceArgs($constructParams);
			}
			else
			{
				$service = $class->newInstance();
			}
		}
		
		return $service;
	}
	
	/**
	 * Build constructor params for object.
	 * @param array $constructParamsConfig
	 * @return array
	 */
	private function buildConstructParams(array $constructParamsConfig)
	{
		$constructParams = array();
		foreach ($constructParamsConfig as $parameter => $config)
		{
			if (is_array($config))
			{
				if (array_key_exists('service', $config))
				{
					$constructParams[] = $this->getService($config['service']);
				}

				if (array_key_exists('class', $config))
				{
					$myConstructParamsConfig = isset($config['constructParams']) ? $config['constructParams'] : array();
					$class = new \ReflectionClass($config['class']);
					if ( ! empty($myConstructParamsConfig))
					{
						$myConstructParams = $this->buildConstructParams($myConstructParamsConfig);
						$object = $class->newInstanceArgs($myConstructParams);
					}
					else
					{
						$object = $class->newInstance();
					}

					$constructParams[] = $object;
				}
			}
			elseif (is_scalar($config))
			{
				$constructParams[] = $config;
			}
		}
		
		return $constructParams;
	}
}
	