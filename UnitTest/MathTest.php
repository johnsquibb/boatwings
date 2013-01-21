<?php
require_once __DIR__ . '/FrameworkTest.php';

use \BoatWings\Type\TypeMathException;
use \BoatWings\Type\TypeInteger;
use \BoatWings\Type\TypeFloat;
use \BoatWings\Type\TypeMath;

class MathTest extends FrameworkTest
{
	public function testAddNumbersAsIntegers()
	{
		$a = new TypeInteger(2);
		$b = new TypeInteger(3);
		$c = TypeMath::add($a, $b);
		$this->assertInstanceOf('\BoatWings\Type\TypeInteger', $c);
		$this->assertEquals(5, $c->getValue());
	}
	
	public function testAddNumbersAsFloats()
	{
		$a = new TypeFloat(2.5);
		$b = new TypeFloat(3.6);
		$c = TypeMath::add($a, $b);
		$this->assertInstanceOf('\BoatWings\Type\TypeFloat', $c);
		$this->assertEquals(6.1, $c->getValue());
	}
	
	public function testAddNumbersAsMixed()
	{
		$a = new TypeInteger(2);
		$b = new TypeFloat(3.6);
		$c = TypeMath::add($a, $b);
		$this->assertInstanceOf('\BoatWings\Type\TypeFloat', $c);
		$this->assertEquals(5.6, $c->getValue());
	}
	
	public function testSubtractNumbersAsIntegers()
	{
		$a = new TypeInteger(2);
		$b = new TypeInteger(3);
		$c = TypeMath::subtract($a, $b);
		$this->assertInstanceOf('\BoatWings\Type\TypeInteger', $c);
		$this->assertEquals(-1, $c->getValue());
	}
	
	public function testSubtractNumbersAsFloats()
	{
		$a = new TypeFloat(2.5);
		$b = new TypeFloat(3.6);
		$c = TypeMath::subtract($a, $b);
		$this->assertInstanceOf('\BoatWings\Type\TypeFloat', $c);
		$this->assertEquals(-1.1, $c->getValue());
	}
	
	public function testSubtractNumbersAsMixed()
	{
		$a = new TypeInteger(2);
		$b = new TypeFloat(3.6);
		$c = TypeMath::subtract($a, $b);
		$this->assertInstanceOf('\BoatWings\Type\TypeFloat', $c);
		$this->assertEquals(-1.6, $c->getValue());
	}
	
	public function testMultiplyNumbersAsIntegers()
	{
		$a = new TypeInteger(2);
		$b = new TypeInteger(3);
		$c = TypeMath::multiply($a, $b);
		$this->assertInstanceOf('\BoatWings\Type\TypeInteger', $c);
		$this->assertEquals(6, $c->getValue());
	}
	
	public function testMultiplyNumbersAsFloats()
	{
		$a = new TypeFloat(2.5);
		$b = new TypeFloat(3.6);
		$c = TypeMath::multiply($a, $b);
		$this->assertInstanceOf('\BoatWings\Type\TypeFloat', $c);
		$this->assertEquals(9, $c->getValue());
	}
	
	public function testMultiplyNumbersAsMixed()
	{
		$a = new TypeInteger(2);
		$b = new TypeFloat(3.6);
		$c = TypeMath::multiply($a, $b);
		$this->assertInstanceOf('\BoatWings\Type\TypeFloat', $c);
		$this->assertEquals(7.2, $c->getValue());
	}
	
	public function testDivideNumbersAsIntegers()
	{
		$a = new TypeInteger(2);
		$b = new TypeInteger(3);
		$c = TypeMath::divide($a, $b);
		$this->assertInstanceOf('\BoatWings\Type\TypeFloat', $c);
		$this->assertEquals(0.66666666666667, $c->getValue());
	}
	
	public function testDivideNumbersAsFloats()
	{
		$a = new TypeFloat(2.5);
		$b = new TypeFloat(3.6);
		$c = TypeMath::divide($a, $b);
		$this->assertInstanceOf('\BoatWings\Type\TypeFloat', $c);
		$this->assertEquals(0.69444444444444, $c->getValue());
	}
	
	public function testDivideNumbersAsMixed()
	{
		$a = new TypeInteger(2);
		$b = new TypeFloat(3.6);
		$c = TypeMath::divide($a, $b);
		$this->assertInstanceOf('\BoatWings\Type\TypeFloat', $c);
		$this->assertEquals(0.55555555555556, $c->getValue());
	}
	
	public function testDivisionByZero()
	{
		$a = new TypeInteger(2);
		$b = new TypeFloat(0.0);
		
		try 
		{
			$c = TypeMath::divide($a, $b);
		}
		catch (TypeMathException $e)
		{
			$this->assertEquals(TypeMathException::DIVISION_BY_ZERO, $e->getCode());
		}
	}
}