<?php
namespace Application\Mvc\Model;

use BoatWings\Mvc\MvcModel;
use BoatWings\Mvc\ModelResult;

class MyModel extends MvcModel
{
	public function demoWithContructedResultData(array $parameters)
	{
		return new ModelResult(
			ModelResult::RESPONSE_SUCCESS,
			array(
				'message' => 'Response from demo model data',
				'inputParams' => $parameters
			)
		);
	}
	
	public function demoWithSetMethodResultData(array $parameters)
	{
		$modelResult = new ModelResult();
		$modelResult->setResponse(ModelResult::RESPONSE_SUCCESS);
		$modelResult->setData(
			array(
				'message' => 'Response from demo model data',
				'inputParams' => $parameters
			)
		);
		return $modelResult;
	}
	
	public function demoConditionalResponseData(array $parameters)
	{
		if (isset($parameters['condition']))
		{
			$dataResult = new ModelResult();
			
			switch ($parameters['condition'])
			{
				case 'A':
					$dataResult->setResponse(ModelResult::RESPONSE_SUCCESS);
					$dataResult->setData(array('messageFromTheModel' => 'Condition A was met.'));
				break;
			
				case 'B':
					$dataResult->setResponse(ModelResult::RESPONSE_SUCCESS);
					$dataResult->setData(array('messageFromTheModel' => 'Condition B was met.'));
				break;
			
				default: 
					throw new \Exception("Invalid condition parameter.");
				break;
			}
			
			return $dataResult;
		}
		else
		{
			throw new \Exception('Expected condition key in parameters');
		}
	}
}