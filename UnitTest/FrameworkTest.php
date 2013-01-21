<?php

require_once dirname(__DIR__) . '/BoatWings/Framework/Bootstrap.php';

class FrameworkTest extends PHPUnit_Framework_TestCase 
{	
	public function testFrameworkBootstrapComplete()
	{
		$isBootstrapped = constant('BOATWINGS_BOOTSTRAP_COMPLETE');
		$this->assertTrue($isBootstrapped);
	}
}