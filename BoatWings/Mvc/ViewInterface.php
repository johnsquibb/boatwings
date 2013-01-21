<?php
namespace BoatWings\Mvc;

interface ViewInterface 
{
	public function __construct($renderContext = NULL, $renderParameters = array());
	public function setRenderContext($render);
	public function getRenderContext();
	public function setRenderParameters(array $parameters);
	public function getRenderParameters();
	public function processRender();
	public function getRenderResult();
}