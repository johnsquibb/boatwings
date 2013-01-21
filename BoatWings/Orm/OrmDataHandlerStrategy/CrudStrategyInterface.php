<?php
namespace BoatWings\Orm\OrmDataHandlerStrategy;

interface CrudStrategyInterface 
{
	public function create($identifier, $data);
	public function read($identifier);
	public function update($identifier, $data);
	public function delete($identifier);
}