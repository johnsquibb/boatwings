<?php
namespace BoatWings\Orm;

class OrmSchema 
{
	private $ormSchemaObjects = array();
	
	/**
	 * Normalize lookup string.
	 * @param type $typeString
	 * @return type
	 */
	protected function normalizeTypeString($typeString)
	{
		return strtolower($typeString);
	}
	
	/**
	 * Add new OrmObject to Schema.
	 * @param type $typeString
	 * @param OrmObject $object
	 */
	public function addObject($typeString, OrmObject $object)
	{
		$normTypeString = $this->normalizeTypeString($typeString);
		
		$this->ormSchemaObjects[$normTypeString] = $object;
	}
	
	/**
	 * Get an instance of OrmObject referenced by string.
	 * @param type $typeString
	 * @return type
	 */
	public function getObjectInstance($typeString)
	{
		$normTypeString = $this->normalizeTypeString($typeString);
		if (isset($this->ormSchemaObjects[$normTypeString]))
		{
			return clone $this->ormSchemaObjects[$normTypeString];
		}
	}
}