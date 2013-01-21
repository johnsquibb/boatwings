<?php

require_once __DIR__ . '/FrameworkTest.php';

use Application\Mvc\Controller\MyController;
use BoatWings\Mvc\ControllerResult;
use Application\Mvc\Model\MyModel;
use BoatWings\Mvc\ModelResult;
use Application\Mvc\View\MyView;
use BoatWings\Mvc\ViewResult;
use BoatWings\Mvc\MvcService;
use BoatWings\Service\ServiceFactoryWrapper;

class MvcTest extends FrameworkTest 
{	
	public function testMyControllerController() 
	{
		$parameters = array('one' => 1, 'two' => 2, 'three' => 3);	
		
		$myController = new MyController();
		
		$myController->setActionContext('demoWithContructedResult');
		$myController->setActionParameters($parameters);
		$myController->processAction();
		$actionResult = $myController->getActionResult();
		
		$this->assertInstanceOf('\BoatWings\Mvc\MvcResultInterface', $actionResult);
		$this->assertEquals($actionResult->getResponse(), ControllerResult::RESPONSE_SUCCESS);
		$this->assertEquals($actionResult->getData(), 
			array(
				'message' => 'Response from demo controller action', 
				'inputParams' => $parameters
			)
		);
		
		$myController->setActionContext('demoWithSetMethodResult');
		$myController->processAction();
		$myController->setActionParameters($parameters);
		$actionResult = $myController->getActionResult();
		
		$this->assertInstanceOf('\BoatWings\Mvc\MvcResultInterface', $actionResult);
		$this->assertEquals($actionResult->getResponse(), ControllerResult::RESPONSE_SUCCESS);
		$this->assertEquals($actionResult->getData(), 
			array(
				'message' => 'Response from demo controller action', 
				'inputParams' => $parameters
			)
		);
	}
	
	public function testMyModelModel()
	{
		$parameters = array('one' => 1, 'two' => 2, 'three' => 3);
		
		$myModel = new MyModel();
		
		$myModel->setDataContext('demoWithContructedResult');
		$myModel->setDataParameters($parameters);
		$myModel->processData();
		$dataResult = $myModel->getDataResult();
		
		$this->assertInstanceOf('\BoatWings\Mvc\MvcResultInterface', $dataResult);
		$this->assertEquals($dataResult->getResponse(), ModelResult::RESPONSE_SUCCESS);
		$this->assertEquals($dataResult->getData(), 
			array(
				'message' => 'Response from demo model data', 
				'inputParams' => $parameters
			)
		);
		
		$myModel->setDataContext('demoWithSetMethodResult');
		$myModel->setDataParameters($parameters);
		$myModel->processData();
		$dataResult = $myModel->getDataResult();
		
		$this->assertInstanceOf('\BoatWings\Mvc\MvcResultInterface', $dataResult);
		$this->assertEquals($dataResult->getResponse(), ModelResult::RESPONSE_SUCCESS);
		$this->assertEquals($dataResult->getData(), 
			array(
				'message' => 'Response from demo model data', 
				'inputParams' => $parameters
			)
		);
	}
	
	public function testMyViewView()
	{
		$parameters = array('one' => 1, 'two' => 2, 'three' => 3);
		
		$myView = new MyView();
		
		$myView->setRenderContext('demoWithContructedResult');
		$myView->setRenderParameters($parameters);
		$myView->processRender();
		$renderResult = $myView->getRenderResult();
		
		$this->assertInstanceOf('\BoatWings\Mvc\MvcResultInterface', $renderResult);
		$this->assertEquals($renderResult->getResponse(), ViewResult::RESPONSE_SUCCESS);
		$this->assertEquals($renderResult->getData(), 
			array(
				'message' => 'Response from demo view render', 
				'inputParams' => $parameters
			)
		);
		
		$myView->setRenderContext('demoWithSetMethodResult');
		$myView->setRenderParameters($parameters);
		$myView->processRender();
		$renderResult = $myView->getRenderResult();
		
		$this->assertInstanceOf('\BoatWings\Mvc\MvcResultInterface', $renderResult);
		$this->assertEquals($renderResult->getResponse(), ViewResult::RESPONSE_SUCCESS);
		$this->assertEquals($renderResult->getData(), 
			array(
				'message' => 'Response from demo view render', 
				'inputParams' => $parameters
			)
		);
	}
	
	public function testMvcComponentsWorkingTogether()
	{
		$myController = new MyController(
			'demoWithControllerLoadingModelAndView',
			array('condition' => 'A')	
		);
		
		// Expect controller to return view repsonse matching condition A.
		$myController->processAction();
		$actionResult = $myController->getActionResult();
		$this->assertTrue(array_key_exists('messageFromTheView', $actionResult->getData()));
		$this->assertTrue(in_array('Condition A was met.', $actionResult->getData()));
		
		// Expect controller to return view repsonse matching condition B.
		$myController->setActionParameters(array('condition' => 'B'));
		$myController->processAction();
		$actionResult = $myController->getActionResult();
		$this->assertTrue(array_key_exists('messageFromTheView', $actionResult->getData()));
		$this->assertTrue(in_array('Condition B was met.', $actionResult->getData()));
	}
	
	public function testMvcServiceExecuteControllerContext()
	{
		$actionParameters = array('one' => 1, 'two' => 2, 'three' => 3);	
		$actionContext = 'demoWithContructedResult';
		$controllerClass = 'Application\Mvc\Controller\MyController';
		
		$mvcService = new MvcService();
		$actionResult = $mvcService->executeControllerActionContext($controllerClass, $actionContext, $actionParameters);
		$this->assertInstanceOf('\BoatWings\Mvc\ControllerResult', $actionResult);
	}
	
	public function testMvcServiceExecuteModelContext()
	{
		$dataParameters = array('one' => 1, 'two' => 2, 'three' => 3);	
		$dataContext = 'demoWithContructedResult';
		$modelClass = 'Application\Mvc\Model\MyModel';
		
		$mvcService = new MvcService();
		$dataResult = $mvcService->executeModelDataContext($modelClass, $dataContext, $dataParameters);
		$this->assertInstanceOf('\BoatWings\Mvc\ModelResult', $dataResult);
	}
	
	public function testMvcServiceExecuteViewContext()
	{
		$renderParameters = array('one' => 1, 'two' => 2, 'three' => 3);	
		$renderContext = 'demoWithContructedResult';
		$viewClass = 'Application\Mvc\View\MyView';
		
		$mvcService = new MvcService();
		$renderResult = $mvcService->executeViewRenderContext($viewClass, $renderContext, $renderParameters);
		$this->assertInstanceOf('\BoatWings\Mvc\ViewResult', $renderResult);
	}
	
	public function testMvcServiceExecuteControllerContextUsingServiceFactory()
	{		
		$actionResult = ServiceFactoryWrapper::getService('MvcService')
			->executeControllerActionContext(
				'Application\Mvc\Controller\MyController', 
				'demoWithContructedResult', 
				array('one' => 1, 'two' => 2, 'three' => 3)
			);
		
		$this->assertInstanceOf('\BoatWings\Mvc\ControllerResult', $actionResult);
	}
	
	public function testMvcServiceExecuteModelContextUsingServiceFactory()
	{		
		$dataResult = ServiceFactoryWrapper::getService('MvcService')
			->executeModelDataContext(
				'Application\Mvc\Model\MyModel', 
				'demoWithContructedResult', 
				array('one' => 1, 'two' => 2, 'three' => 3)
			);
		
		$this->assertInstanceOf('\BoatWings\Mvc\ModelResult', $dataResult);
	}
	
	public function testMvcServiceExecuteViewContextUsingServiceFactory()
	{		
		$renderResult = ServiceFactoryWrapper::getService('MvcService')
			->executeViewRenderContext(
				'Application\Mvc\View\MyView', 
				'demoWithContructedResult', 
				array('one' => 1, 'two' => 2, 'three' => 3)
			);
		
		$this->assertInstanceOf('\BoatWings\Mvc\ViewResult', $renderResult);
	}
}