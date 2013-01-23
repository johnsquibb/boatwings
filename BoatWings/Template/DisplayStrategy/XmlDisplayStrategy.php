<?php
namespace BoatWings\Template\DisplayStrategy;

class XmlDisplayStrategy implements DisplayStrategyInterface 
{
	/**
	 * Data from which XML tree is built.
	 * @var type 
	 */
	private $input = array();
	
	/**
	 * Get string of XML output.
	 * @return type
	 * @throws \Exception
	 */
	public function getOutput()
	{
		if (count($this->input))
		{
			$root = array_shift(array_keys($this->input));
			$initialXml = "<?xml version=\"1.0\" standalone=\"yes\"?><{$root}></{$root}>";
			$sxe = new \SimpleXMLElement($initialXml);
			
			// Process child elements.
			if (is_array($this->input[$root]))
			{
				$this->addChildren($sxe, $this->input[$root]);
			}
			
			return $sxe->asXML();
		}
		else
		{
			throw new \Exception("Call to setInput() required prior to executing getOutput().");
		}
	}
	
	/**
	 * Add children to XML tree.
	 * @param \SimpleXMLElement $sxe
	 * @param array $children
	 * @param type $defaultChildName
	 */
	private function addChildren(\SimpleXMLElement $sxe, array $children, $defaultChildName = 'item')
	{
		foreach ($children as $childName => $childValue)
		{
			// Use supplied default instead of numeric indexes.
			if (is_numeric($childName)) $childName = $defaultChildName;
			
			if (is_array($childValue))
			{
				$child = $sxe->addChild($childName);
				$this->addChildren($child, $childValue);
			}
			else
			{
				$child = $sxe->addChild($childName, $childValue);
			}
		}
	}

	/**
	 * Set input data.
	 * @param array $input
	 * @throws \Exception
	 */
	public function setInput(array $input)
	{
		if (count($input))
		{
			$this->input = $input;
		}
		else
		{
			throw new \Exception("Input must contain an array with root element as first key.");
		}
	}
}