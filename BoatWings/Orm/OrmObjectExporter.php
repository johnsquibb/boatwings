<?php
namespace BoatWings\Orm;

use \BoatWings\Orm\OrmObjectExporterStrategy\ExportStrategyInterface;
use \BoatWings\Orm\OrmObject;
use \BoatWings\Type\TypeInterface;

class OrmObjectExporter 
{
	/**
	 * Export encode method.
	 * @var type 
	 */
	private $strategyContext;
	
	/**
	 * __construct.
	 * @param \Orm\OrmObjectExporterStrategy\ExportStrategyInterface $strategyContext
	 */
	public function __construct(ExportStrategyInterface $strategyContext)
	{
		$this->strategyContext = $strategyContext;
	}
	
	/**
	 * Export OrmObject to format determined by strategy context.
	 * @param \Orm\OrmObject $ormObject
	 * @return type
	 */
	public function exportOrmObject(OrmObject $ormObject)
	{
		$exportArray = $this->exportOrmObjectToDataArray($ormObject);
		return $this->strategyContext->encodeExportData($exportArray); 
	}
	
	/**
	 * Export OrmObject data to associative array.
	 * @param \Orm\OrmObject $ormObject
	 * @return type
	 */
	private function exportOrmObjectToDataArray(OrmObject $ormObject)
	{
		$data = array();
		
		foreach ($ormObject->getMemberList() as $member)
		{
			$getter = 'get' . ucfirst($member);
			$value = $ormObject->$getter();
			$data[$member] = $this->exportOrmObjectMemberValue($value);
		}
		
		return $data;
	}
	
	/**
	 * Export OrmObject member value.
	 * Used for recursion of various types and OrmObjects.
	 * @param type $memberValue
	 * @return type
	 */
	private function exportOrmObjectMemberValue($memberValue)
	{
		if ($memberValue instanceof OrmObject)
		{
			return $this->exportOrmObjectToDataArray($memberValue);
		}
		
		if ($memberValue instanceof TypeInterface)
		{
			return $this->exportTypeInterfaceValue($memberValue);
		}
	}
	
	/**
	 * Export TypeInterface implementer value.
	 * @param type $memberValue
	 * @return type
	 */
	private function exportTypeInterfaceValue($memberValue)
	{
		return $memberValue->getValue();
	}
}