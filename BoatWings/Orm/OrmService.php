<?php
namespace BoatWings\Orm;

use BoatWings\Orm\OrmObjectFactory;

class OrmService 
{
	private $factory;
	
	/**
	 * __construct.
	 * @param \BoatWings\Orm\OrmObjectFactory $factory
	 */
	public function __construct(OrmObjectFactory $factory)
	{
		$this->factory = $factory;
	}
	
	/**
	 * Factory an OrmObject.
	 * @param type $type
	 * @return type
	 */
	public function factoryOrmObject($type)
	{
		return $this->factory->getOrmObject($type);
	}
	
	/**
	 * Factory and hydrate an OrmObject.
	 * @param type $type
	 */
	public function loadOrmObject($type)
	{
		
	}
	
	/**
	 * Dehydrate and save an OrmObject.
	 * @param \BoatWings\Orm\OrmObject $ormObject
	 */
	public function saveOrmObject(OrmObject $ormObject)
	{
		
	}
}