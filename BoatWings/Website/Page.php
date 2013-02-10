<?php
namespace BoatWings\Website;

use \BoatWings\Template\DisplayStrategy\DisplayStrategyInterface;

abstract class Page 
{
  /**
   * Whether to buffer output streams.
   * @var type 
   */
  private $bufferOutput = TRUE;
  
  /**
   * Maintains __construct() call state.
   * When this class is not properly constructed, unexpected behavior can occur.
   * @var type 
   */
  private $constructed = FALSE;
  
  /**
   * Display strategy to use when streaming output.
   * @var type 
   */
  private $displayStrategy;
  
  /**
   * __construct.
   * Starts buffer to be flushed in __destruct(). 
   */
  public function __construct()
  {
    if ($this->bufferOutput === TRUE)
    {
      ob_start();
    }
    
    $this->constructed = TRUE;
  }
  
  /**
   * Set displayStrategy.
   * @param \BoatWings\Template\DisplayStrategy\DisplayStrategyInterface $strategy
   */
  protected function setDisplayStrategy(DisplayStrategyInterface $strategy)
  {
    $this->displayStrategy = $strategy;
  }
  
  /**
   * Get displayStrategy.
   * @return type
   */
  protected function getDisplayStrategy()
  {
    return $this->displayStrategy;
  }
  
  /**
   * Stream supplied content.
   * @param type $content
   * @throws \Exception
   */
  protected function streamContent($content)
  {
    if (is_string($content))
    {
      echo $content;
    }
    else
    {
      throw new \Exception('Content supplied to stream() must be a string.');
    }
  }
  
  /**
   * __destruct.
   * Flushes buffer created in __construct().
   * @throws \Exception
   */
  public function __destruct()
  {
    if ($this->constructed === TRUE)
    {    
      if ($this->bufferOutput === TRUE)
      {
        ob_end_flush();
      }
    }
    else
    {
      throw new \Exception(
        "Parent class 'Page' was not properly constructed." . 
        " Ensure call to parent::__construct() in overloaded method."
      );
    }
  }
}