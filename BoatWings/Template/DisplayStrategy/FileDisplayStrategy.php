<?php
namespace BoatWings\Template\DisplayStrategy;

class FileDisplayStrategy implements DisplayStrategyInterface
{
	/**
	 * Location of file to load.
	 * @var type 
	 */
	protected $file;
	
	/**
	 * Get buffered output data.
	 * @return type
	 * @throws \Exception
	 */
	public function getOutput()
	{
		if (isset($this->file))
		{
			// Start buffer, load template, return buffered output.
			ob_start();
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
		if (isset($input['file']))
		{
			if (is_readable($input['file']))
			{
				$this->file = $input['file'];
			}
			else
			{
				throw new \Exception("Input array must contain key 'file' pointing to valid readable file.");
			}
		}
		else
		{
			throw new \Exception("Input array must contain key 'file'");
		}
	}

}