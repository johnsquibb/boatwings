<?php
namespace BoatWings\Website;

use BoatWings\Template\DisplayStrategy\PhpFileDisplayStrategy;
use BoatWings\Website\Page;

abstract class PhpPage extends Page 
{
  /**
   * Maintains __construct() call state.
   * When this class is not properly constructed, unexpected behavior can occur.
   * @var type 
   */
  private $constructed = FALSE;
  
  /**
   * __construct.
   */
  public function __construct()
  {
    parent::__construct();
    $this->setDisplayStrategy(new PhpFileDisplayStrategy());
    $this->constructed = TRUE;
  }
  
  /**
   * Set template.
   * @param type $file
   * @param type $data
   */
  protected function setTemplate($file, $data)
  {
    $input = array(
			'file' => $file,
			'data' => $data
		);
    
    $this->getDisplayStrategy()->setInput($input);		
  }
  
  /**
   * Stream template content.
   */
  protected function streamTemplate()
  {
    $output = $this->getDisplayStrategy()->getOutput();
    $this->streamContent($output);
  }
  
  /**
   * __destruct.
   * @throws \Exception
   */
  public function __destruct()
  {
    if ($this->constructed === TRUE)
    {    
      parent::__destruct();
    }
    else
    {
      throw new \Exception(
        "Parent class 'PhpPage' was not properly constructed." . 
        " Ensure call to parent::__construct() in overloaded method."
      );
    }
  }
}