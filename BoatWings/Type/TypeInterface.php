<?php
namespace BoatWings\Type;

interface TypeInterface 
{
	public function validateValue($value);
	public function getValue();	
	public function setValue($value);	
	public function __toString();
	public function __sleep();
}