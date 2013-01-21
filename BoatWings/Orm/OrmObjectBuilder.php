<?php
namespace BoatWings\Orm;

class OrmObjectBuilder 
{
	/**
	 * Build and hydrate an object using supplied configuration array.
	 * @param array $config
	 * @return type
	 */
	public function buildFromConfigArray(array $config)
	{
		return $this->buildObjectFromConfigArray($config);
	}
	
	/**
	 * Build object from configuration array.
	 * Supports recursion for nested OrmObject members.
	 * @param array $config
	 * @return \OrmObject
	 * @throws \Exception
	 */
	private function buildObjectFromConfigArray(array $config)
	{
		$object = new OrmObject();
		if (isset($config['members']))
		{
			foreach ($config['members'] as $member => $memberConfig)
			{
				if (is_array($memberConfig))
				{
					$hasMemberName = 'has' . ucfirst($member);
					$hasMemberValue = $this->buildMemberValueFromConfigArray($memberConfig);				
					$object->$hasMemberName($hasMemberValue);
				}
				else
				{
					throw new \Exception("OrmObjectBuilder requires that each member contain a 'type' attribute");
				}
			}
		}
		
		return $object;
	}
	
	/**
	 * Build OrmObject members from member configuration array.
	 * Routes to internal methods depending on type (OrmObject vs BasicType interface implementer).
	 * @param array $memberConfig
	 * @return type
	 */
	private function buildMemberValueFromConfigArray(array $memberConfig)
	{
		$hasMemberValue = NULL;
		switch ($memberConfig['type'])
		{
			// OrmObject builder.
			case 'OrmObject':
				$hasMemberValue = $this->buildObjectFromConfigArray($memberConfig);
			break;

			// TypeInterface builder.
			default:
				$hasMemberValue = $this->buildTypeInterfaceValueFromConfigArray($memberConfig);
			break;
		}
		
		return $hasMemberValue;
	}
	
	/**
	 * Build TypeInterface implementer object from member configuration array.
	 * @param array $memberConfig
	 * @return \memberType
	 * @throws \Exception
	 */
	private function buildTypeInterfaceValueFromConfigArray(array $memberConfig)
	{
		$hasMemberValue = NULL;
		if (isset($memberConfig['type']))
		{
			$memberType = $memberConfig['type'];
			if (class_exists($memberType))
			{					
				if (isset($memberConfig['value']))
				{
					$memberValue = $memberConfig['value'];
				}
				else
				{
					$memberValue = NULL;
				}

				$hasMemberValue = new $memberType($memberValue);
			}
			else
			{
				throw new \Exception("OrmObjectBuilder requires that each member contain a 'type' attribute naming a valid existing Type class");
			}
		}
		
		return $hasMemberValue;
	}
}