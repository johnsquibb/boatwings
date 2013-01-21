<?php
namespace BoatWings\Type;

class TypeFloat extends TypeNumber implements TypeInterface
{	
	/**
	 * Validate Float value.
	 * @param type $value
	 * @return boolean
	 * @throws TypeDataException
	 */
	public function validateValue($value)
	{
		if (is_float($value))
		{
			return TRUE;
		}
		else
		{
			throw new TypeDataException(
				'Invalid data supplied to ' . __CLASS__, 
				TypeDataException::INVALID_FLOAT
			);
		}
	}
}