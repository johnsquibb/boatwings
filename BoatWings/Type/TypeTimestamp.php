<?php
namespace BoatWings\Type;

class TypeTimestamp extends TypeRangedFloat 
{	
	private $dateArray = array();
	
	public function __construct($value = NULL)
	{
		if ( ! isset($value)) $value = microtime(TRUE);
		parent::__construct($value);
		$this->initialize();
	}
	
	protected function initialize()
	{
		$this->dateArray = getdate($this->value);
	}
	
	public function getDateArray()
	{
		return $this->dateArray;
	}
	
	public function getSeconds()
	{
		return $this->dateArray['seconds'];
	}
	
	public function getMinutes()
	{
		return $this->dateArray['minutes'];
	}

	public function getHours()
	{
		return $this->dateArray['hours'];
	}
	
	public function getDayOfMonth()
	{
		return $this->dateArray['mday'];
	}
	
	public function getDayOfWeek()
	{
		return $this->dateArray['wday'];
	}
	
	public function getMonthNumber()
	{
		return $this->dateArray['mon'];
	}
	
	public function getYear()
	{
		return $this->dateArray['year'];
	}
	
	public function getDayOfYear()
	{
		return $this->dateArray['yday'];
	}
	
	public function getWeekday()
	{
		return $this->dateArray['weekday'];
	}
	
	public function getMonth()
	{
		return $this->dateArray['month'];
	}
	
	public function getUnixTimestamp()
	{
		return $this->dateArray[0];
	}
	
	public function set($value)
	{
		parent::setValue($value);
		$this->initialize();
	}

}