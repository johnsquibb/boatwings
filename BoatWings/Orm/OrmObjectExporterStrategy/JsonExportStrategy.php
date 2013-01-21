<?php
namespace BoatWings\Orm\OrmObjectExporterStrategy;

class JsonExportStrategy implements ExportStrategyInterface
{
	/**
	 * Encode the exportArray data.
	 * @param array $exportArray
	 * @return type
	 */
	public function encodeExportData(array $exportArray)
	{
		return json_encode($exportArray);
	}	
}