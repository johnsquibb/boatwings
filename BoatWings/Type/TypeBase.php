<?php
namespace BoatWings\Type;

abstract class TypeBase 
{
	protected $value;
	
	/**
	 * Construct.
	 * @param type $value
	 */
	public function __construct($value = NULL)
	{
		if (isset($value) && $this->validateValue($value))
		{
			$this->value = $value;
		}
	}
	
	/**
	 * Get Value.
	 * @return type
	 */
	public function getValue() 
	{
		return $this->value;
	}
	
	/**
	 * Set Value.
	 * @param type $value
	 */
	public function setValue($value)
	{
		if ($this->validateValue($value))
		{
			$this->value = $value;
		}
	}
	
	/**
	 * __toString magic method.
	 * @return type
	 */
	public function __toString()
	{
		return (string) $this->value;
	}
	
	/**
	 * __sleep magic method.
	 * @return type
	 */
	public function __sleep()
	{
		return array('value');
	}
}