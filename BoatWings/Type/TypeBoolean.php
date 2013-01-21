<?php
namespace BoatWings\Type;

class TypeBoolean extends TypeBase implements TypeInterface 
{
	protected $value = FALSE;
	
	/**
	 * Validate Boolean value.
	 * @param type $value
	 * @return boolean
	 * @throws TypeDataException
	 */
	public function validateValue($value)
	{
		if (is_bool($value))
		{
			return TRUE;
		}
		else
		{
			throw new TypeDataException(
				'Invalid data supplied to ' . __CLASS__, 
				TypeDataException::INVALID_BOOLEAN
			);
		}
	}	
}