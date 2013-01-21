<?php
namespace BoatWings\Mvc;

interface MvcResultInterface 
{
	public function setResponse($response);
	public function getResponse();
	public function setData(array $data);
	public function getData();
	public function isSuccess();
	public function isError();
}