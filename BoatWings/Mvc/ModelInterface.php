<?php
namespace BoatWings\Mvc;

interface ModelInterface 
{
	public function __construct($dataContext = NULL, $dataParameters = array());
	public function setDataContext($data);
	public function getDataContext();
	public function setDataParameters(array $parameters);
	public function getDataParameters();
	public function processData();
	public function getDataResult();
}