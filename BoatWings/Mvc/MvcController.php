<?php
namespace BoatWings\Mvc;

abstract class MvcController implements ControllerInterface
{
	private $actionContext;
	private $actionMethod;
	private $actionParameters = array();
	private $actionResult;
	
	public function __construct($actionContext = NULL, $actionParameters = array())
	{
		if ($actionContext !== NULL)
		{
			$this->setActionContext($actionContext);
		}
		
		$this->setActionParameters($actionParameters);
	}
	
	public function getActionContext()
	{
		return $this->actionContext;
	}

	public function getActionResult()
	{
		return $this->actionResult;
	}

	public function processAction()
	{
		$actionMethod = $this->actionMethod;
		$parameters = $this->getActionParameters();
		
		if (is_callable(array($this, $actionMethod)))
		{
			$actionResult = $this->$actionMethod($parameters);
			if ($actionResult instanceof MvcResultInterface)
			{
				$this->actionResult = $actionResult;
			}
			else
			{
				throw new \Exception("Return value from controller action method '{$actionMethod}' " . 
					"must return an instance of MvcResultInterface");
			}
		}
		else
		{
			throw new \Exception('Cannot run controller action. Controller actionMethod not set. ' . 
				'Perform setActionContext() with valid action string first.');
		}
	}

	public function setActionContext($action)
	{
		$method = "{$action}Action";
		
		if  (method_exists($this, $method))
		{
			$this->actionContext = $action;
			$this->actionMethod = $method;
		}
		else
		{
			throw new \Exception("Invalid action context. Controller Method '{$method}' does not exist.");
		}
	}
	
	public function getActionParameters()
	{
		return $this->actionParameters;
	}

	public function setActionParameters(array $parameters)
	{
		$this->actionParameters = $parameters;
	}
}
