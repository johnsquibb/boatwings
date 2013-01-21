<?php
namespace BoatWings\Type;

class TypeInteger extends TypeNumber implements TypeInterface
{	
	/**
	 * Validate Integer value.
	 * @param type $value
	 * @return boolean
	 * @throws TypeDataException
	 */
	public function validateValue($value)
	{
		if (is_integer($value))
		{
			return TRUE;
		}
		else
		{
			throw new TypeDataException(
				'Invalid data supplied to ' . __CLASS__, 
				TypeDataException::INVALID_INTEGER
			);
		}
	}
	
	/**
	 * Increment Integer value.
	 */
	public function increment($offset = 1)
	{
		$this->value += $offset;
	}
	
	/**
	 * Decrement Integer value. 
	 */
	public function decrement($offset = 1)
	{
		$this->value -= $offset;
	}
}