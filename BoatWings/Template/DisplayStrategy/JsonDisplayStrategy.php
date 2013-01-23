<?php
namespace BoatWings\Template\DisplayStrategy;

class JsonDisplayStrategy implements DisplayStrategyInterface
{
	/**
	 * Data from which JSON output is built.
	 * @var type 
	 */
	private $input;
	
	/**
	 * Get JSON output.
	 * @return type
	 */
	public function getOutput()
	{
		return json_encode($this->input);
	}

	/**
	 * Set input data.
	 * @param array $input
	 */
	public function setInput(array $input)
	{
		$this->input = $input;
	}
}