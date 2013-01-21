<?php
namespace BoatWings\Type;

class TypeString extends TypeBase implements TypeInterface 
{	
	/**
	 * Validate String value.
	 * @param type $value
	 * @return boolean
	 * @throws TypeDataException
	 */
	public function validateValue($value)
	{
		if (is_string($value))
		{
			return TRUE;
		}
		else
		{
			throw new TypeDataException(
				'Invalid data supplied to ' . __CLASS__, 
				TypeDataException::INVALID_STRING
			);
		}
	}
	
	/**
	 * Get String length.
	 * @return type
	 */
	public function getLength()
	{
		return strlen($this->value);
	}
}