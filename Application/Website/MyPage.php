<?php
namespace Application\Website;

use Application\Mvc\Controller\MyController;
use BoatWings\Website\PhpPage;

class MyPage extends PhpPage 
{  
  /**
   * Demonstrates use of MVC components to generate data for output by PHP template.
   * @param array $parameters
   */
  public function myPageAsPhp(array $parameters)
  {
    $myController = new MyController(
			'demoWithControllerLoadingModelAndView',
			array('condition' => 'A')	
		);
    
    // Expect controller to return view repsonse matching condition A.
		$myController->processAction();
		$actionResult = $myController->getActionResult();
		
    // Set the actionResult::data into PHP template.
		$this->setTemplate(
			dirname(__DIR__) . '/resource/templates/MyPage.php',
			$actionResult->getData()
		);
				
    // Generate output.
    $this->streamTemplate();
  }
}