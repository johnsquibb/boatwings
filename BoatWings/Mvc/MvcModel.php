<?php
namespace BoatWings\Mvc;

abstract class MvcModel implements ModelInterface
{
	private $dataContext;
	private $dataMethod;
	private $dataParameters = array();
	private $dataResult;
	
	public function __construct($dataContext = NULL, $dataParameters = array())
	{
		if ($dataContext !== NULL)
		{
			$this->setDataContext($dataContext);
		}
		
		$this->setDataParameters($dataParameters);
	}
	
	public function getDataContext()
	{
		return $this->dataContext();
	}

	public function getDataParameters()
	{
		return $this->dataParameters;
	}

	public function getDataResult()
	{
		return $this->dataResult;
	}

	public function processData()
	{
		$dataMethod = $this->dataMethod;
		$parameters = $this->getDataParameters();
		
		if (is_callable(array($this, $dataMethod)))
		{
			$dataResult = $this->$dataMethod($parameters);
			if ($dataResult instanceof MvcResultInterface)
			{
				$this->dataResult = $dataResult;
			}
			else
			{
				throw new \Exception("Return value from model data method '{$dataMethod}' " . 
					"must return an instance of MvcResultInterface");
			}
		}
		else
		{
			throw new \Exception('Cannot run model action. Model dataMethod not set. ' . 
				'Perform setDataContext() with valid data string first.');
		}
	}

	public function setDataContext($data)
	{
		$method = "{$data}Data";
		
		if  (method_exists($this, $method))
		{
			$this->dataContext = $data;
			$this->dataMethod = $method;
		}
		else
		{
			throw new \Exception("Invalid data context. Model Method '{$method}' does not exist.");
		}
	}

	public function setDataParameters(array $parameters)
	{
		$this->dataParameters = $parameters;
	}

}