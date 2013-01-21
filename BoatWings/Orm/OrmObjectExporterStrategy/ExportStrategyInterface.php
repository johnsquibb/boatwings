<?php
namespace BoatWings\Orm\OrmObjectExporterStrategy;

interface ExportStrategyInterface 
{
	public function encodeExportData(array $exportArray);
}