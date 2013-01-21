<?php
namespace BoatWings\Type;

class TypeEnum extends TypeBase 
{	
	public function __construct($items)
	{
		$this->value = new TypeArray();
		
		$items = func_get_args();
		foreach ($items as $item)
		{
			$this->value->append(new TypeString($item));
		}
	}
	
	public function getItems()
	{
		return $this->value->getSortedValue();
	}
	
	public function getEnumerations()
	{
		$list = array();
		foreach ($this->getItems() as $item) $list[] = $item->getValue();
		
		return $list;
	}
		
	public function hasItem($item)
	{
		$items = $this->value;
		return $items->hasValue(new TypeString($item), $items::TYPE_LOOSE);
	}
}