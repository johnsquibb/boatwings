<?php
namespace BoatWings\Template\DisplayStrategy;

class PhpFileDisplayStrategy extends FileDisplayStrategy
{
	/**
	 * Data containing variables for PHP template.
	 * @var type 
	 */
	protected $data = array();
	
	/**
	 * Get buffered string output from PHP file.
	 * @return type
	 * @throws \Exception
	 */
	public function getOutput()
	{
		if (isset($this->file))
		{
			// Start buffer, import data into local scope, load template, return buffered output.
			ob_start();
			extract($this->data);
			require($this->file);
			$output = ob_get_clean();
			return $output;
		}
		else
		{
			throw new \Exception("Call to setInput() required prior to executing getOutput().");
		}
	}

	/**
	 * Set input data.
	 * @param array $input
	 * @throws \Exception
	 */
	public function setInput(array $input)
	{
		// FileDisplayStrategy handles file set.
		parent::setInput($input);
		
		if (isset($input['data']))
		{
			if (is_array($input['data']))
			{
				$this->data = $input['data'];
			}
			else
			{
				throw new \Exception("Optional input key 'data' must contain an array");
			}
		}
	}

}