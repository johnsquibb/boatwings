<?php
namespace BoatWings\Type;

class TypeMath 
{
	/**
	 * Add values.
	 * @param TypeNumber $a
	 * @param TypeNumber $b
	 * @return type
	 */
	public static function add(TypeNumber $a, TypeNumber $b)
	{
		$sum = $a->getValue() + $b->getValue();
		return (is_integer($sum)) ? new TypeInteger($sum) : new TypeFloat($sum);
	}
	
	/**
	 * Subtract values.
	 * @param TypeNumber $a
	 * @param TypeNumber $b
	 * @return type
	 */
	public static function subtract(TypeNumber $a, TypeNumber $b)
	{
		$difference =  $a->getValue() - $b->getValue();
		return (is_integer($difference)) ? new TypeInteger($difference) : new TypeFloat($difference);
	}
	
	/**
	 * Multiply values.
	 * @param TypeNumber $a
	 * @param TypeNumber $b
	 * @return type
	 */
	public static function multiply(TypeNumber $a, TypeNumber $b)
	{
		$product = $a->getValue() * $b->getValue();
		return (is_integer($product)) ? new TypeInteger($product) : new TypeFloat($product);
	}
	
	/**
	 * Divide values.
	 * @param TypeNumber $a
	 * @param TypeNumber $b
	 * @return type
	 * @throws TypeMathException
	 */
	public static function divide(TypeNumber $a, TypeNumber $b)
	{
		if ($b->getValue() == 0)
		{
			throw new TypeMathException('Division by zero.', TypeMathException::DIVISION_BY_ZERO);
		}
		
		$quotient = $a->getValue() / $b->getValue();
		return (is_integer($quotient)) ? new TypeInt($quotient) : new TypeFloat($quotient);
	}
}