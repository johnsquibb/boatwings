<?php
namespace BoatWings\Orm;

abstract class OrmRouter extends OrmDataContainer
{		
	/**
	 * ORM has/get/set dynamic method router.
	 * @param type $method
	 * @param type $arguments
	 * @return type
	 * @throws \Exception
	 */
	public function __call($method, $arguments)
	{
		$prefix = substr($method, 0, 3);
		$member = substr($method, 3);
		
		switch (strtolower($prefix))
		{
			case 'has':
				$this->initializeOrmDataValue($member, array_shift($arguments));
			break;
		
			case 'get':
				return $this->getOrmDataValue($member);
			break;
		
			case 'set':
				$this->setOrmDataValue($member, array_shift($arguments));
			break;
		
			default:
				throw new \Exception("Unknown OrmRouter::__call() condition: {$method}");
			break;
		}
	}
}