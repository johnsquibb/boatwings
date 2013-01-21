<?php
namespace BoatWings\Orm\OrmDataHandlerStrategy;

class LocalMemoryDataStrategy implements CrudStrategyInterface
{
	/**
	 * Local memory data store.
	 * @var type 
	 */
	private $database = array();
	
	/**
	 * Create entry for identifier in local data store.
	 * @param type $identifier
	 * @param type $data
	 */
	public function create($identifier, $data)
	{
		$this->validateIdentifier($identifier);
		
		$this->database[$identifier] = $data;
	}

	/**
	 * Delete entry for identifier in local data store.
	 * @param type $identifier
	 */
	public function delete($identifier)
	{
		$this->validateIdentifier($identifier);
		
		unset($this->database[$identifier]);
	}

	/**
	 * Read data for identifier from local data store.
	 * @param type $identifier
	 * @return type
	 */
	public function read($identifier)
	{
		$this->validateIdentifier($identifier);
		
		if (isset($this->database[$identifier]))
		{
			return $this->database[$identifier];
		}
	}

	/**
	 * Update data for identifier in local data store.
	 * @param type $identifier
	 * @param type $data
	 */
	public function update($identifier, $data)
	{
		$this->validateIdentifier($identifier);
		
		$this->database[$identifier] = $data;
	}
	
	/**
	 * Validate identifier.
	 * @param type $identifier
	 * @throws \Exception
	 */
	private function validateIdentifier($identifier)
	{
		if ($identifier === NULL)
		{
			throw new \Exception('The identifier cannot be NULL');
		}
	}
}