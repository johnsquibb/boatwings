<?php
namespace BoatWings\Orm\OrmObjectImporterStrategy;

interface ImportStrategyInterface 
{
	
	public function decodeImportData($importData);
}