<?php
namespace BoatWings\Template\DisplayStrategy;

interface DisplayStrategyInterface 
{
	public function setInput(array $input);
	public function getOutput();
}