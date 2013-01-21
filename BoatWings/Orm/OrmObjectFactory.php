<?php
namespace BoatWings\Orm;

use \BoatWings\Configuration\YamlConfigurationLoader;
use \BoatWings\Configuration\YamlConfigurationParser;

class OrmObjectFactory 
{
	private $loader;
	private $parser;
	private $builder;
	
	public function __construct(
		YamlConfigurationLoader $loader, 
		YamlConfigurationParser $parser, 
		OrmObjectBuilder $builder
	)
	{
		$this->loader = $loader;
		$this->parser = $parser;
		$this->builder = $builder;
	}
	
	public function getOrmObject($type)
	{
		$relativeConfigPath = $type . '.yml';
		$yaml = $this->loader->loadConfiguration($relativeConfigPath);

		if ($yaml !== NULL)
		{
			$config = $this->parser->parseYaml($yaml);
			if (is_array($config))
			{
				$object = $this->builder->buildFromConfigArray($config);
				return $object;
			}
		}
	}
}