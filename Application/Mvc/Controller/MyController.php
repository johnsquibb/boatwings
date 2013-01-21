<?php
namespace Application\Mvc\Controller;

use BoatWings\Mvc\MvcController;
use BoatWings\Mvc\ControllerResult;
use BoatWings\Mvc\ModelResult;
use BoatWings\Mvc\ViewResult;
use Application\Mvc\Model\MyModel;
use Application\Mvc\View\MyView;
use BoatWings\Service\ServiceFactoryWrapper;

class MyController extends MvcController
{
	public function demoWithContructedResultAction(array $parameters)
	{
		return new ControllerResult(
			ControllerResult::RESPONSE_SUCCESS,
			array(
				'message' => 'Response from demo controller action',
				'inputParams' => $parameters
			)
		);
	}
	
	public function demoWithSetMethodResultAction(array $parameters)
	{
		$controllerResult = new ControllerResult();
		$controllerResult->setResponse(ControllerResult::RESPONSE_SUCCESS);
		$controllerResult->setData(
			array(
				'message' => 'Response from demo controller action',
				'inputParams' => $parameters
			)
		);
		return $controllerResult;
	}
	
	public function demoWithControllerLoadingModelAndViewAction(array $parameters)
	{
		$mvcService = ServiceFactoryWrapper::getService('MvcService');
		
		if (isset($parameters['condition']))
		{
			// First, load conditional data.			
			$dataResult = $mvcService->executeModelDataContext(
				'Application\Mvc\Model\MyModel', 
				'demoConditionalResponse', 
				array('condition' => $parameters['condition'])
			);

			if ($dataResult->isSuccess())
			{
				// Next generate view output.				
				$renderResult = $mvcService->executeViewRenderContext(
					'Application\Mvc\View\MyView', 
					'demoConditionalResponseData', 
					$dataResult->getData()
				);

				if ($renderResult->isSuccess())
				{
					return new ControllerResult(
						ControllerResult::RESPONSE_SUCCESS,
						$renderResult->getData()
					);
				}
				else
				{
					throw new \Exception("Error response from View.");
				}
			}
			else
			{
				throw new \Exception("Error response from Model.");
			}
		}
		else
		{
			throw new \Exception("Expected condition key in parameters.");
		}
	}
}