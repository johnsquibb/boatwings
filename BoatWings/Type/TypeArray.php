<?php
namespace BoatWings\Type;

class TypeArray extends TypeBase implements TypeInterface, \ArrayAccess, \Countable, \Iterator
{
	protected $value = array();
	protected $position = 0;
	
	const TYPE_STRICT = 1;
	const TYPE_LOOSE = 0;
	
	/**
	 * Validate Array value.
	 * @param type $value
	 * @return boolean
	 * @throws TypeDataException
	 */
	public function validateValue($value)
	{
		if (is_array($value))
		{
			return TRUE;
		}
		else
		{
			throw new TypeDataException(
				'Invalid data supplied to ' . __CLASS__, 
				TypeDataException::INVALID_ARRAY
			);
		}
	}	
	
	/**
	 * Get offset exists.
	 * @param type $offset
	 * @return type
	 */
	public function offsetExists($offset)
	{
		return isset($this->value[$offset]);
	}
	
	/**
	 * Get offset.
	 * @param type $offset
	 * @return type
	 */
	public function offsetGet($offset)
	{
		return $this->value[$offset];
	}
	
	/**
	 * Set offset.
	 * @param type $offset
	 * @param type $value
	 */
	public function offsetSet($offset, $value)
	{
		$this->value[$offset] = $value;
	}
	
	/**
	 * Unset offset.
	 * @param type $offset
	 */
	public function offsetUnset($offset)
	{
		unset($this->value[$offset]);
	}
	
	/**
	 * Get count of Array values.
	 * @return type
	 */
	public function count()
	{
		return count($this->value);
	}
	
	/**
	 * Get current Array value at pointer position.
	 * @return type
	 */
	public function current()
	{
		return $this->value[$this->position];
	}
	
	/**
	 * Get current Array pointer position.
	 * @return type
	 */
	public function key()
	{
		return $this->position;
	}
	
	/**
	 * Increment Array pointer position.
	 */
	public function next()
	{
		++$this->position;
	}
	
	/**
	 * Reset array pointer position.
	 */
	public function rewind()
	{
		$this->position = 0;
	}
	
	/**
	 * Check valid Array pointer position.
	 * @return type
	 */
	public function valid()
	{
		return isset($this->value[$this->position]);
	}
	
	/**
	 * Prepend Array element to stack.
	 * @param type $value
	 */
	public function prepend($value)
	{
		array_unshift($this->value, $value);
	}
	
	/**
	 * Append Array element to stack.
	 * @param type $value
	 */
	public function append($value)
	{
		array_push($this->value, $value);
	}
	
	/**
	 * Shift an Array element off the stack.
	 * @return type
	 */
	public function shift()
	{
		return array_shift($this->value);
	}
	
	/**
	 * Pop an Array element off the stack.
	 * @return type
	 */
	public function pop()
	{
		return array_pop($this->value);
	}
	
	/**
	 * Get sorted value list.
	 * @return type
	 */
	public function getSortedValue()
	{
		$arrayValues = $this->getValue();
		sort($arrayValues);
		return $arrayValues;
	}
	
	/**
	 * Search for value in array.
	 * @param type $value
	 * @param type $strict
	 * @return type
	 */
	public function hasValue($value, $strict = self::TYPE_LOOSE)
	{		
		return (array_search($value, $this->value, $strict) !== FALSE);
	}
}