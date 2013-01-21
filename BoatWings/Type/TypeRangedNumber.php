<?php
namespace BoatWings\Type;

abstract class TypeRangedNumber extends TypeNumber 
{
	protected $minValue;
	protected $maxValue;
	
	function __construct($value = NULL, $minValue = -4294967296, $maxValue= 4294967296)
	{		
		$this->minValue = $minValue;
		$this->maxValue = $maxValue;
		
		parent::__construct($value);
	}
	
	public function getMinValue()
	{
		return $this->minValue;
	}
	
	public function getMaxValue()
	{
		return $this->maxValue;
	}
	
	public function setMinValue($minValue)
	{
		$this->minValue = $minValue;
	}
	
	public function setMaxValue($maxValue)
	{
		$this->maxValue = $maxValue;
	}
}
