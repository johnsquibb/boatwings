<?php
namespace BoatWings\Mvc;

abstract class MvcView implements ViewInterface 
{
	private $renderContext;
	private $renderMethod;
	private $renderParameters;
	private $renderResult;
	
	public function __construct($renderContext = NULL, $renderParameters = array())
	{
		if ($renderContext !== NULL)
		{
			$this->setRenderContext($renderContext);
		}
		
		$this->setRenderParameters($renderParameters);
	}
	
	public function getRenderContext()
	{
		return $this->renderContext;
	}

	public function getRenderParameters()
	{
		return $this->renderParameters;
	}

	public function getRenderResult()
	{
		return $this->renderResult;
	}

	public function processRender()
	{
		$renderMethod = $this->renderMethod;
		$parameters = $this->getRenderParameters();
		
		if (is_callable(array($this, $renderMethod)))
		{
			$renderResult = $this->$renderMethod($parameters);
			if ($renderResult instanceof MvcResultInterface)
			{
				$this->renderResult = $renderResult;
			}
			else
			{
				throw new \Exception("Return value from view render method '{$renderMethod}' " . 
					"must return an instance of MvcResultInterface");
			}
		}
		else
		{
			throw new \Exception('Cannot run view render. View renderMethod not set. ' . 
				'Perform setRenderContext() with valid render string first.');
		}
	}

	public function setRenderContext($render)
	{
		$method = "{$render}Render";
		
		if  (method_exists($this, $method))
		{
			$this->renderContext = $render;
			$this->renderMethod = $method;
		}
		else
		{
			throw new \Exception("Invalid render context. View Method '{$method}' does not exist.");
		}
	}

	public function setRenderParameters(array $parameters)
	{
		$this->renderParameters = $parameters;
	}

}