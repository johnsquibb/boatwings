<?php
namespace BoatWings\Type;

class TypeRangedInteger extends TypeRangedNumber implements TypeInterface
{	
	/**
	 * Validate Integer value.
	 * @param type $value
	 * @return boolean
	 * @throws TypeDataException
	 */
	public function validateValue($value)
	{
		if (TypeInteger::validateValue($value))
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