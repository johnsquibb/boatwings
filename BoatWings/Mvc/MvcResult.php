<?php
namespace BoatWings\Mvc;

class MvcResult implements MvcResultInterface 
{
	const RESPONSE_SUCCESS = 1;
	const RESPONSE_ERROR = 2;
	
	private $data;
	private $response;
	
	public function __construct($response = self::RESPONSE_SUCCESS, array $data = array())
	{
		$this->setResponse($response);
		$this->setData($data);
	}
	
	public function getData()
	{
		return $this->data;
	}

	public function getResponse()
	{
		return $this->response;
	}

	public function setData(array $data)
	{
		$this->data = $data;
	}

	public function setResponse($response)
	{
		$this->response = $response;
	}
	
	public function isSuccess()
	{
		return $this->response === self::RESPONSE_SUCCESS;
	}
	
	public function isError()
	{
		return $this->response === self::RESPONSE_ERROR;
	}
}