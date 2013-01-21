<?php
namespace BoatWings\Orm;

use BoatWings\Orm\OrmDataHandlerStrategy\CrudStrategyInterface;
use BoatWings\Orm\OrmObject;
use BoatWings\Orm\OrmObjectImporter;
use BoatWings\Orm\OrmObjectExporter;
use BoatWings\Orm\OrmObjectFactory;

class OrmDataHandler
{
	/**
	 * Create, Read, Update, Delete (CRUD) strategy.
	 * @var type 
	 */
	private $crudStrategy;
	
	/**
	 * OrmObjectFactory.
	 * @var type 
	 */
	private $ormObjectFactory;
	
	/**
	 * OrmObjectImporter.
	 * @var type 
	 */
	private $ormObjectImporter;
	
	/**
	 * OrmObjectExporter.
	 * @var type 
	 */
	private $ormObjectExporter;
	
	/**
	 * __construct.
	 * @param \BoatWings\Orm\OrmDataHandlerStrategy\CrudStrategyInterface $crudStrategy
	 * @param \BoatWings\Orm\OrmObjectFactory $ormObjectFactory
	 * @param \BoatWings\Orm\OrmObjectImporter $ormObjectImporter
	 * @param \BoatWings\Orm\OrmObjectExporter $ormObjectExporter
	 */
	public function __construct(
		CrudStrategyInterface $crudStrategy, 
		OrmObjectFactory $ormObjectFactory,
		OrmObjectImporter $ormObjectImporter, 
		OrmObjectExporter $ormObjectExporter
	)
	{
		$this->crudStrategy = $crudStrategy;
		$this->ormObjectFactory = $ormObjectFactory;
		$this->ormObjectImporter = $ormObjectImporter;
		$this->ormObjectExporter = $ormObjectExporter;
	}
	
	/**
	 * Save OrmObject.
	 * @param \BoatWings\Orm\OrmObject $ormObject
	 * @throws \Exception
	 */
	public function saveOrmObject(OrmObject $ormObject)
	{ 
		$identifier = $ormObject->getIdentifier();
				
		if ($identifier !== NULL)
		{			
			$exportData = $this->ormObjectExporter->exportOrmObject($ormObject);
			
			if ($this->crudStrategy->read($identifier))
			{
				$this->crudStrategy->update($identifier, $exportData);
			}
			else
			{
				$this->crudStrategy->create($identifier, $exportData);
			}
		}
		else
		{
			throw new \Exception('The OrmObject instance identifier must be set using ' . 
				'setIdentifier() prior to calling ' 
				. __CLASS__ . ':' . __FUNCTION__ . '() method.'
			);
		}
	}
	
	/**
	 * Load OrmObject
	 * @param type $type
	 * @param type $identifier
	 * @return type
	 */
	public function loadOrmObject($type, $identifier)
	{
		$importData = $this->crudStrategy->read($identifier);
		if ($importData !== NULL)
		{		
			$ormObject = $this->ormObjectFactory->getOrmObject($type);
			$this->ormObjectImporter->importOrmObject($ormObject, $importData);
			$ormObject->setIdentifier($identifier);
			return $ormObject;
		}
	}
	
	/**
	 * Delete OrmObject.
	 * @param type $identifier
	 */
	public function deleteOrmObject($identifier)
	{
		$this->crudStrategy->delete($identifier);
	}
}