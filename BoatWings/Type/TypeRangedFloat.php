<?php
namespace BoatWings\Type;

class TypeRangedFloat extends TypeRangedNumber implements TypeInterface
{	
	/**
	 * Validate Float value.
	 * @param type $value
	 * @return boolean
	 * @throws TypeDataException
	 */
	public function validateValue($value)
	{
		if (TypeFloat::validateValue($value))
		{
			if ($value >= $this->getMinValue() && $value <= $this->getMaxValue())
			{
				return TRUE;
			}
			else
			{
				throw new TypeDataException(
					'Invalid range supplied to ' . __CLASS__, 
					TypeDataException::INVALID_NUMBER_RANGE
				);
			}
		}
	}
}