<?php
namespace BoatWings\Orm;

abstract class OrmDataContainer 
{
	protected $ormData = array();
	
	/**
	 * Normalize lookup key.
	 * @param type $dataKey
	 * @return type
	 */
	protected function normalizeDataKey($dataKey)
	{
		return strtolower($dataKey);
	}
	
	/**
	 * Get data value by key.
	 * @param type $dataKey
	 * @return type
	 */
	protected function getOrmDataValue($dataKey)
	{
		$normDataKey = $this->normalizeDataKey($dataKey);
		
		if (isset($this->ormData[$normDataKey]))
		{			
			return $this->ormData[$normDataKey];			
		}	
	}
	
	/**
	 * Set dataKey value.
	 * @param type $dataKey
	 * @param type $value
	 * @throws \Exception
	 */
	protected function setOrmDataValue($dataKey, $value)
	{		
		$normDataKey = $this->normalizeDataKey($dataKey);
		
		if (isset($this->ormData[$normDataKey]))
		{
			// Enforce type check.
			if ($this->ormData[$normDataKey] instanceof $value) 
			{
				$this->ormData[$normDataKey] = $value;
			}
			else
			{
				$expectedType = get_class($this->ormData[$normDataKey]);
				throw new \Exception("Expected instance of {$expectedType} for '{$dataKey}'.");
			}
		}			
	}
	
	/**
	 * Initialize OrmData value with object to be used for strict type check during set.
	 * @param type $dataKey
	 * @param type $typeObject
	 */
	protected function initializeOrmDataValue($dataKey, $typeObject)
	{
		$normDataKey = $this->normalizeDataKey($dataKey);
		
		// We'll use the supplied type for strict enforcement during set().
		$this->ormData[$normDataKey] = $typeObject;
	}
}