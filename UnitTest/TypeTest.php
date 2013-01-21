<?php
require_once __DIR__ . '/FrameworkTest.php';

use \BoatWings\Type\TypeString;
use \BoatWings\Type\TypeArray;
use \BoatWings\Type\TypeDataException;
use \BoatWings\Type\TypeInteger;
use \BoatWings\Type\TypeFloat;
use \BoatWings\Type\TypeBoolean;
use \BoatWings\Type\TypeRangedInteger;
use \BoatWings\Type\TypeTimestamp;
use \BoatWings\Type\TypeEnum;

class TypeTest extends FrameworkTest
{
	public function testStringType()
	{
		// Test deafult initialization.
		$string = new TypeString();
		$this->assertEquals(NULL, $string->getValue());
		
		// String.
		$value = 'This is a string';
		$string = new TypeString($value);
		$this->assertEquals($value, $string->getValue());
		
		// Cast.
		$castValue = (string) $string;
		$this->assertEquals($value, $castValue);
		
		// Overwrite String.
		$newValue = 'This is a new string';
		$string->setValue($newValue);
		$this->assertEquals($newValue, $string->getValue());
		
		// Not a String.
		try 
		{
			$string = new TypeString(array('Not a string'));
		}
		catch (TypeDataException $e)
		{
			$this->assertSame(TypeDataException::INVALID_STRING, $e->getCode());
		}
		
		// Test string length.
		$string = new TypeString("This string is 34 characters long.");
		$this->assertEquals(34, $string->getLength());
	}
	
	public function testIntegerType()
	{
		// Test deafult initialization.
		$integer = new TypeInteger();
		$this->assertEquals(0, $integer->getValue());
		
		// Int.
		$value = 1234567890;
		$integer = new TypeInteger($value);
		$this->assertEquals($value, $integer->getValue());
		
		// Cast.
		$castValue = (string) $integer;
		$this->assertEquals($value, $castValue);
		
		// Overwrite Integer.
		$newValue = 42;
		$integer->setValue($newValue);
		$this->assertEquals($newValue, $integer->getValue());
		
		// Not an Int.
		try 
		{
			$integer = new TypeInteger(1.456);
		}
		catch (TypeDataException $e)
		{
			$this->assertSame(TypeDataException::INVALID_INTEGER, $e->getCode());
		}
	}
	
	public function testFloatType()
	{
		// Test deafult initialization.
		$float = new TypeFloat();
		$this->assertEquals(0, $float->getValue());
		
		// Float.
		$value = 3.14;
		$float = new TypeFloat($value);
		$this->assertEquals($value, $float->getValue());
		
		// Cast.
		$castValue = (string) $float;
		$this->assertEquals($value, $castValue);
		
		// Overwrite Float.
		$newValue = 3.145678;
		$float->setValue($newValue);
		$this->assertEquals($newValue, $float->getValue());
		
		// Not a Float.
		try 
		{
			$float = new TypeFloat(123);
		}
		catch (TypeDataException $e)
		{
			$this->assertSame(TypeDataException::INVALID_FLOAT, $e->getCode());
		}
	}
	
	public function testBooleanType()
	{
		// Test deafult initialization.
		$bool = new TypeBoolean();
		$this->assertEquals(FALSE, $bool->getValue());
		
		// Boolean.
		$value = TRUE;
		$boolean = new TypeBoolean($value);
		$this->assertEquals($value, $boolean->getValue());
		
		// Cast.
		$castValue = (string) $boolean;
		$this->assertEquals($value, $castValue);
		
		// Overwrite Boolean.
		$newValue = FALSE;
		$boolean->setValue($newValue);
		$this->assertEquals($newValue, $boolean->getValue());
		
		// Not a Boolean.
		try 
		{
			$boolean = new TypeBoolean(50);
		}
		catch (TypeDataException $e)
		{
			$this->assertSame(TypeDataException::INVALID_BOOLEAN, $e->getCode());
		}
	}
	
	public function testArrayType()
	{
		// Test deafult initialization.
		$array = new TypeArray();
		$this->assertEquals(array(), $array->getValue());
		
		// Array.
		$value = array('A', 'B', 'C');
		$array = new TypeArray($value);
		$this->assertEquals($value, $array->getValue());
		
		// Cast.
		$castValue = (string) $array;
		$this->assertEquals('Array', $castValue);
		
		// Overwrite Array.
		$newValue = array('D', 'E', 'F');
		$array->setValue($newValue);
		$this->assertEquals($newValue, $array->getValue());
		
		// Not an Array.
		try 
		{
			$array = new TypeArray('NOT AN ARRAY');
		}
		catch (TypeDataException $e)
		{
			$this->assertSame(TypeDataException::INVALID_ARRAY, $e->getCode());
		}
		
		// Array Access.
		$fourthValue = 'Four!';
		$array[3] = $fourthValue;
		$this->assertEquals($fourthValue, $array[3]);
		unset($array[3]);
		$this->assertFalse(isset($array[3]));
		
		// Countable.
		$this->assertEquals(3, count($array));
		
		// Iterable.
		foreach ($array as $key => $value)
		{
			$this->assertEquals($array[$key], $value);
		}
	}
	
	public function testArrayOfTypes()
	{
		// Array[String].
		$array = new TypeArray();
		$array[0] = new TypeString();
		$value = 'My String Value';
		$array[0]->setValue($value);
		$this->assertInstanceOf('BoatWings\Type\TypeString', $array[0]);
		$this->assertEquals($value, $array[0]->getValue());
		
		// Array[Integer]
		$array[1] = new TypeInteger();
		$array[1]->setValue(123);
		$this->assertInstanceOf('BoatWings\Type\TypeInteger', $array[1]);
		$this->assertEquals(123, $array[1]->getValue());
	}
	
	public function testArrayStackManipulation()
	{
		$array = new TypeArray(array(2));
		
		// Prepend an element.
		$array->prepend(1);
		
		// Append an element
		$array->append(3);
		
		$this->assertEquals(array(1, 2, 3), $array->getValue());
		
		// Shift an element off.
		$value = $array->shift();
		$this->assertEquals(1, $value);
		
		// Pop an element off.
		$value = $array->pop();
		$this->assertEquals(3, $value);
		
		$this->assertEquals(array(2), $array->getValue());
	}

	public function testArrayTypeSort()
	{
		// Test assignment order.
		$values = array(22, 6, 10);
		$array = new TypeArray($values);
		$this->assertEquals($values, $array->getValue());
		
		// Test sort order.
		sort($values);
		$this->assertEquals($values, $array->getSortedValue());
	}
	
	public function testArrayTypeSearch()
	{
		// Create array.
		$string = new TypeString('John');
		$integer = new TypeInteger(10);
		$float = new TypeFloat(3/2);
		$array = new TypeArray(array($string, $integer, $float));
		
		// Ensure values are present.
		$this->assertTrue($array->hasValue($float));
		$this->assertTrue($array->hasValue($integer));
		$this->assertTrue($array->hasValue($string));
		
		// Ensure values are not present.
		$this->assertFalse($array->hasValue('Tacos'));
		
		// hasValue() will return true on loose comparison...
		$this->assertTrue($array->hasValue(new TypeFloat(3/2)));
		// and FALSE on strict comparison when item is not the same.
		$this->assertFalse($array->hasValue(new TypeFloat(3/2), TRUE));
		$this->assertTrue($array->hasValue($float, TRUE));
	}
	
	public function testRangedNumberType()
	{
		$rangedInteger = new TypeRangedInteger();
		$rangedInteger->setMaxValue(10);
		$rangedInteger->setMinValue(5);
		$rangedInteger->setValue(6);
		$this->assertEquals(10, $rangedInteger->getMaxValue());
		$this->assertEquals(5, $rangedInteger->getMinValue());
		$this->assertEquals(6, $rangedInteger->getValue());
		
		// Bad Range.
		try 
		{
			$rangedInteger->setValue(-1);
		}
		catch (TypeDataException $e)
		{
			$this->assertEquals(TypeDataException::INVALID_NUMBER_RANGE, $e->getCode());
		}
		
		// Another.
		$rangedInteger2 = new TypeRangedInteger(10, -10, 10);
		$this->assertEquals(10, $rangedInteger2->getMaxValue());
		$this->assertEquals(-10, $rangedInteger2->getMinValue());
		$this->assertEquals(10, $rangedInteger2->getValue());
	}
	
	public function testTimestampType()
	{
		$now = microtime(TRUE);
		$timestamp = new TypeTimestamp($now);
		$this->assertEquals($now, $timestamp->getValue());
		
		// Check date array.
		$date = getdate($now);
		$this->assertEquals($date['seconds'], $timestamp->getSeconds());
		$this->assertEquals($date['minutes'], $timestamp->getMinutes());
		$this->assertEquals($date['hours'], $timestamp->getHours());
		$this->assertEquals($date['mday'], $timestamp->getDayOfMonth());
		$this->assertEquals($date['wday'], $timestamp->getDayOfWeek());
		$this->assertEquals($date['mon'], $timestamp->getMonthNumber());
		$this->assertEquals($date['year'], $timestamp->getYear());
		$this->assertEquals($date['yday'], $timestamp->getDayOfYear());
		$this->assertEquals($date['weekday'], $timestamp->getWeekDay());
		$this->assertEquals($date['month'], $timestamp->getMonth());
		$this->assertEquals($date[0], $timestamp->getUnixTimestamp());
	}
	
	public function testEnum()
	{
		$enum = new TypeEnum('toast', 'biscuits', 'muffins');
		$this->assertTrue($enum->hasItem('toast'));
		$this->assertFalse($enum->hasItem('butter'));
		$this->assertEquals(array('biscuits', 'muffins', 'toast'), $enum->getEnumerations());
	}
}