<?php
namespace BoatWings\Orm;

use \BoatWings\Orm\OrmObjectImporterStrategy\ImportStrategyInterface;
use \BoatWings\Orm\OrmObject;
use \BoatWings\Type\TypeInterface;

class OrmObjectImporter 
{
	/**
	 * Import decode method.
	 * @var type 
	 */
	private $strategyContext;
	
	/**
	 * __construct.
	 * @param \BoatWings\Orm\OrmObjectImporterStrategy\ImportStrategyInterface $strategyContext
	 */
	public function __construct(ImportStrategyInterface $strategyContext)
	{
		$this->strategyContext = $strategyContext;
	}
	
	/**
	 * Import object from format determined by strategy context.
	 * @param \BoatWings\Orm\OrmObject $ormObject
	 * @param type $importData
	 * @return type
	 */
	public function importOrmObject(OrmObject $ormObject, $importData)
	{
		$importArray = $this->strategyContext->decodeImportData($importData);
		
		if (is_array($importArray))
		{
			return $this->importOrmObjectFromDataArray($ormObject, $importArray);		
		}
	}
	
	/**
	 * Import OrmObject member values from associative data array.
	 * @param \BoatWings\Orm\OrmObject $ormObject
	 * @param array $importArray
	 */
	private function importOrmObjectFromDataArray(OrmObject $ormObject, array $importArray)
	{
		foreach ($ormObject->getMemberList() as $member)
		{			
			if (array_key_exists($member, $importArray))
			{				
				$setter = 'set' . ucfirst($member);
				$value = $this->importOrmObjectMemberValue($ormObject, $member, $importArray[$member]);
				
				if ($value !== NULL)
				{
					$ormObject->$setter($value);
				}
			}
		}
	}
	
	/**
	 * Import OrmObject member value.
	 * Used for recursion of various types and OrmObjects.
	 * @param \BoatWings\Orm\OrmObject $ormObject
	 * @param type $member
	 * @param type $importValue
	 * @return type
	 */
	private function importOrmObjectMemberValue(OrmObject $ormObject, $member, $importValue)
	{
		$getter = 'get' . ucfirst($member);
		$memberValue = $ormObject->$getter();
		
		if ($memberValue instanceof OrmObject)
		{
			return $this->importOrmObjectFromDataArray($memberValue, $importValue);
		}
		
		if ($memberValue instanceof TypeInterface)
		{
			return $this->importTypeInterfaceValue($memberValue, $importValue);
		}
	}
	
	/**
	 * Import TypeInterface implementer value.
	 * @param type $memberValue
	 * @param type $importValue
	 * @return \BoatWings\Orm\type
	 * @throws \Exception
	 */
	private function importTypeInterfaceValue($memberValue, $importValue)
	{
		$type = get_class($memberValue);
		
		if (class_exists($type))
		{
			return new $type($importValue);
		}
		else
		{
			throw new \Exception("Invalid type supplied. Type '{$type}' does not exist.");
		}		
	}
	
}