<?php
namespace BoatWings\Type;

class TypeDataException extends \Exception 
{
	const INVALID_STRING = 1;
	const INVALID_INTEGER = 2;
	const INVALID_FLOAT = 3;
	const INVALID_ARRAY = 4;
	const INVALID_BOOLEAN = 5;
	const INVALID_NUMBER_RANGE = 6;
}