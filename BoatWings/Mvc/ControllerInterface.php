<?php
namespace BoatWings\Mvc;

interface ControllerInterface 
{
	public function __construct($actionContext = NULL, $actionParameters = array());
	public function setActionContext($action);
	public function getActionContext();
	public function setActionParameters(array $parameters);
	public function getActionParameters();
	public function processAction();
	public function getActionResult();
}