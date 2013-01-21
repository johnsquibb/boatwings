<?php
namespace BoatWings\Orm;
use BoatWings\Type\TypeTimestamp;

class OrmObject extends OrmRouter
{	
	/**
	 * Object identifier.
	 * @var type 
	 */
	private $identifier;
	
	/**
	 * Set identifier.
	 * @param type $identifier
	 */
	public function setIdentifier($identifier)
	{
		$this->identifier = $identifier;
	}
	
	/**
	 * Get identifier.
	 * @return type
	 */
	public function getIdentifier()
	{
		return $this->identifier;
	}
		
	/**
	 * Import data using array key/value map.
	 * @param array $data
	 */
	public function importArray(array $data)
	{
		foreach ($data as $dataKey => $value)
		{
			$this->setOrmDataValue($dataKey, $value);
		}
	}
	
	/**
	 * Magical __clone.
	 */
	public function __clone()
	{
		// Clone any nested objects, or all clones of this object will share same references.
		foreach ($this->ormData as $ormDataKey => $ormDataValue)
		{
			if (is_object($ormDataValue))
			{
				$this->ormData[$ormDataKey] = clone $ormDataValue;
			}
		}
	}
	
	/**
	 * Return array list of members.
	 * @return type
	 */
	public function getMemberList()
	{
		return array_keys($this->ormData);
	}
}