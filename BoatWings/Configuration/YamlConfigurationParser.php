<?php
namespace BoatWings\Configuration;

class YamlConfigurationParser 
{	
	/**
	 * Parse YAML string.
	 * @param type $yaml
	 * @return type
	 */
	public function parseYaml($yaml)
	{
		return yaml_parse($yaml);
	}
}