<?php

require_once __DIR__ . '/FrameworkTest.php';

use BoatWings\Template\DisplayStrategy\JsonDisplayStrategy;
use BoatWings\Template\DisplayStrategy\PhpFileDisplayStrategy;
use BoatWings\Template\DisplayStrategy\FileDisplayStrategy;
use \BoatWings\Template\DisplayStrategy\XmlDisplayStrategy;

class TemplateTest extends FrameworkTest
{
	public function testJsonDisplayStrategy()
	{
		$displayStrategy = new JsonDisplayStrategy();
		$input = array(1, 2, 3);
		$displayStrategy->setInput($input);
		$output = $displayStrategy->getOutput();
		
		$this->assertEquals(json_encode($input), $output);
	}
	
	public function testFileDisplayStrategy()
	{
		$displayStrategy = new FileDisplayStrategy();
		$input = array(
			'file' => __DIR__ . '/mock/templates/FileDisplayStrategy.php'
		);
		
		$displayStrategy->setInput($input);
		$output = $displayStrategy->getOutput();
		$this->assertNotNull($output);
	}
	
	public function testPhpFileDisplayStrategy()
	{
		$displayStrategy = new PhpFileDisplayStrategy();
		$input = array(
			'file' => __DIR__ . '/mock/templates/PhpFileDisplayStrategy.php',
			'data' => array(
				'a' => 'The value of a',
				'b' => 'The value of b',
				'c' => 'The value of c'
			)
		);
		
		$displayStrategy->setInput($input);
		$output = $displayStrategy->getOutput();
		$this->assertNotNull($output);
	}
	
	public function testXmlDisplayStrategy()
	{
		$displayStrategy = new XmlDisplayStrategy();
		$input = array
		(
			// Root element is always the first key.
			'stuff' => array(		
				'people' => array(
					array(
						'name' => 'John',
						'occupation' => 'Programmer',
						'location' => 'Las Vegas'
					),
					array(
						'name' => 'Doug',
						'occupation' => 'Sheriff',
						'location' => 'Las Vegas'
					),
					array(
						'name' => 'Carolyn',
						'occupation' => 'Mayor',
						'location' => 'Las Vegas'
					)
				),
				'places' => array(
					array(
						'name' => 'Las Vegas'
					),
					array(
						'name' => 'Los Angeles'
					),
					array(
						'name' => 'San Francisco'
					),
				)	
			)		
		);
		$displayStrategy->setInput($input);
		$xml = $displayStrategy->getOutput();
		$this->assertNotNull($xml);
	}
}