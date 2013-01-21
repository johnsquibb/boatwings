<?php
namespace Application\Mvc\View;

use BoatWings\Mvc\MvcView;
use BoatWings\Mvc\ViewResult;

class MyView extends MvcView
{
	public function demoWithContructedResultRender(array $parameters)
	{
		return new ViewResult(
			ViewResult::RESPONSE_SUCCESS,
			array(
				'message' => 'Response from demo view render',
				'inputParams' => $parameters
			)
		);
	}
	
	public function demoWithSetMethodResultRender(array $parameters)
	{
		$viewResult = new ViewResult();
		$viewResult->setResponse(ViewResult::RESPONSE_SUCCESS);
		$viewResult->setData(
			array(
				'message' => 'Response from demo view render',
				'inputParams' => $parameters
			)
		);
		return $viewResult;
	}
	
	public function demoConditionalResponseDataRender(array $parameters)
	{
		if (isset($parameters['messageFromTheModel']))
		{
			return new ViewResult(
				ViewResult::RESPONSE_SUCCESS,
				array(
					'messageFromTheView' => $parameters['messageFromTheModel'],
				)
			);
		}
		else
		{
			throw new \Exception('Expected messageFromTheModel key in parameters.');
		}
	}
}