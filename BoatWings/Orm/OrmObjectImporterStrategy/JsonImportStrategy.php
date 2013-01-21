<?php
namespace BoatWings\Orm\OrmObjectImporterStrategy;

class JsonImportStrategy implements ImportStrategyInterface
{
	/**
	 * Decode the importData string.
	 * @param type $importData
	 */
	public function decodeImportData($importData)
	{
		return json_decode($importData, TRUE);
	}

}