<?php

require_once __DIR__ . '/FrameworkTest.php';

use \BoatWings\Configuration\YamlConfigurationLoader;
use \BoatWings\Configuration\YamlConfigurationParser;

use \BoatWings\Orm\OrmObject;
use \BoatWings\Orm\OrmObjectBuilder;
use \BoatWings\Orm\OrmSchema;
use \BoatWings\Orm\OrmObjectFactory;
use \BoatWings\Orm\OrmService;
use \BoatWings\Orm\OrmObjectExporter;
use \BoatWings\Orm\OrmObjectImporter;
use \BoatWings\Orm\OrmObjectExporterStrategy\JsonExportStrategy;
use \BoatWings\Orm\OrmObjectImporterStrategy\JsonImportStrategy;

use \BoatWings\Type\TypeString;
use \BoatWings\Type\TypeArray;

use BoatWings\Service\ServiceFactoryWrapper;

class OrmTest extends FrameworkTest
{
	public function testOrmObjectSetupViaGetterSetter()
	{
		$firstName = 'John';
		$lastName = 'Squibb';
		
		$user = new OrmObject();
		$user->hasFirstName(new TypeString());
		$user->hasLastName(new TypeString());
		$user->setFirstName(new TypeString($firstName));	
		$user->setLastName(new TypeString($lastName));
		
		$this->assertEquals($firstName, $user->getFirstName());
		$this->assertEquals($lastName, $user->getLastName());		
	}
	
	public function testOrmObjectSetupViaArrayConfiguration()
	{
		$data = array (
			'firstName' => new TypeString('John'),
			'lastName' => new TypeString('Squibb')
		);
		
		$user = new OrmObject();
		$user->hasFirstName(new TypeString());
		$user->hasLastName(new TypeString());
		$user->importArray($data);
		
		$this->assertEquals($data['firstName'], $user->getFirstName());
		$this->assertEquals($data['lastName'], $user->getLastName());
	}
	
	public function testOrmNestedSetupViaGetterSetter()
	{
		$firstName = new TypeString('John');
		$lastName = new TypeString('Squibb');
		$street = new TypeString('123 Any Street');
		$city = new TypeString('Las Vegas');
		
		$address = new OrmObject();
		$address->hasStreet(new TypeString());
		$address->hasCity(new TypeString());
		
		$user = new OrmObject();
		$user->hasFirstName(new TypeString());
		$user->hasLastName(new TypeString());
		$user->hasAddress($address);
		
		$user->setFirstName($firstName);
		$user->setLastname($lastName);
		$user->setAddress($address);
		$address->setStreet($street);
		$address->setCity($city);
				
		$this->assertEquals($firstName, $user->getFirstName());
		$this->assertEquals($lastName, $user->getLastName());
		$this->assertEquals($street, $address->getStreet());
		$this->assertEquals($city, $address->getCity());
		$this->assertEquals($address, $user->getAddress());
		$this->assertEquals($city, $user->getAddress()->getCity());
		$this->assertEquals($street, $user->getAddress()->getStreet());
	}
	
	public function testBuildOrmSchemaObjects()
	{
		$user = new OrmObject();
		$user->hasUsername(new TypeString());
		
		$profile = new OrmObject();
		$profile->hasFavorites(new TypeArray());
		$user->hasProfile($profile);
		
		$schema = new OrmSchema();
		
		$schema->addObject('User', $user);
		$schema->addObject('Profile', $profile);
		
		// Create unique user instance.
		$username = new TypeString('user1');
		$userInstance1 = $schema->getObjectInstance('User');
		$this->assertInstanceOf('\BoatWings\Orm\OrmObject', $userInstance1);
		$userInstance1->setUsername($username);
		$this->assertEquals($username, $userInstance1->getUsername());
		
		// Add some favorites to first user.
		$favorites = $userInstance1->getProfile()->getFavorites();
		$favorites->append('Tacos');
		$favorites->append('Burritos');
		$favorites->append('Nachos');
				
		// Create another unique user instance.
		$username = new TypeString('user2');
		$userInstance2 = $schema->getObjectInstance('User');
		$this->assertInstanceOf('\BoatWings\Orm\OrmObject', $userInstance2);
		$userInstance2->setUsername($username);		
		$this->assertEquals($username, $userInstance2->getUsername());
				
		// Add some favorites to second user.
		$favorites = $userInstance2->getProfile()->getFavorites();
		$favorites->append('Pizza');
		$favorites->append('Ravioli');
		$favorites->append('Spaghetti');
		
		// Ensure user data is unique.
		$this->assertNotSame($userInstance1, $userInstance2);
		$this->assertNotEquals($userInstance1->getUsername(), $userInstance2->getUsername());
		$this->assertNotSame($userInstance1->getProfile(), $userInstance2->getProfile());
		$this->assertNotSame(
				$userInstance1->getProfile()->getFavorites(), 
				$userInstance2->getProfile()->getFavorites()
		);
		
		// Export.
		$serial = serialize($userInstance1);
		
		// Rehydrate.
		$object = unserialize($serial);

		// Verify integrity.
		$this->assertEquals($object, $userInstance1);
	}
	
	public function testOrmConfigurationParser()
	{
		$parser = new YamlConfigurationParser();
		
		$yaml = file_get_contents(dirname(__DIR__) . '/BoatWings/Orm/Config/Examples/User.yml');
		
		$config = $parser->parseYaml($yaml);
		$this->assertTrue(is_array($config));
	}
	
	public function testOrmConfigurationParserAndObjectBuilder()
	{
		$parser = new YamlConfigurationParser();
		$builder = new OrmObjectBuilder();
		
		// Load and pare object config.
		$yaml = file_get_contents(dirname(__DIR__) . '/BoatWings/Orm/Config/Examples/User.yml');
		$config = $parser->parseYaml($yaml);
		$this->assertTrue(is_array($config));
		
		// Build OrmObject.
		$user = $builder->buildFromConfigArray($config); 
				
		// Ensure proper values.
		$this->assertEquals(new TypeString('John'), $user->getFirstName());
		$this->assertEquals(new TypeString('Squibb'), $user->getLastName());
		$this->assertEquals(
			new TypeArray(array('Tacos', 'Burritos', 'Nachos')), 
			$user->getProfile()->getFavorites()
		);		
		$this->assertEquals(new TypeArray(), $user->getProfile()->getTodoList());
		$user->getProfile()->getTodoList()->append('Buy stuff');
		$this->assertEquals(new TypeArray(array('Buy stuff')), $user->getProfile()->getTodoList());
	}
	
	public function testOrmObjectFactory()
	{
		$loader = new YamlConfigurationLoader(dirname(__DIR__) . '/BoatWings/Orm/Config/Examples');
		$parser = new YamlConfigurationParser();
		$builder = new OrmObjectBuilder();
		$factory = new OrmObjectFactory($loader, $parser, $builder);
		
		$user = $factory->getOrmObject('User');
		$this->assertInstanceOf('BoatWings\Orm\OrmObject', $user);
	}
	
	public function testOrmService()
	{
		$loader = new YamlConfigurationLoader(dirname(__DIR__) . '/BoatWings/Orm/Config/Examples');
		$parser = new YamlConfigurationParser();
		$builder = new OrmObjectBuilder();
		$factory = new OrmObjectFactory($loader, $parser, $builder);
		$service = new OrmService($factory);
		
		$user = $service->factoryOrmObject('User');
		$this->assertInstanceOf('BoatWings\Orm\OrmObject', $user);
	}
	
	public function testOrmServiceFromServiceFactory()
	{
		$loader = new YamlConfigurationLoader(dirname(__DIR__) . '/BoatWings/Service/Config/Examples');
		$parser = new YamlConfigurationParser();
		$serviceFactory = new \BoatWings\Service\ServiceFactory($loader, $parser);
		
		$ormService = $serviceFactory->getService('OrmService');
		$user = $ormService->factoryOrmObject('User');
		$this->assertInstanceOf('BoatWings\Orm\OrmObject', $user);
	}
	
	public function testOrmObjectExporterJsonStrategy()
	{		
		$ormService = ServiceFactoryWrapper::getService('OrmService');
		$user = $ormService->factoryOrmObject('User');
		$this->assertInstanceOf('BoatWings\Orm\OrmObject', $user);
		
		$ormObjectExporter = new OrmObjectExporter(new JsonExportStrategy());
		$jsonData = $ormObjectExporter->exportOrmObject($user);
		$this->assertNotNull(json_decode($jsonData));
	}
	
	public function testOrmObjectImporterJsonStrategy()
	{
		// First, export a hydrated object so we have the JSON.
		$ormService = ServiceFactoryWrapper::getService('OrmService');
		$user = $ormService->factoryOrmObject('User');
		$user->setFirstName(new TypeString('Jeff'));
		$user->getProfile()->getFavorites()->append('Ice Cream');
		$user->getProfile()->getTodoList()->append('Go to the store.');
		$user->getProfile()->getTodoList()->append('Go to work.');
		$user->getProfile()->getTodoList()->append('Go home.');
		$this->assertInstanceOf('BoatWings\Orm\OrmObject', $user);	
		$ormObjectExporter = new OrmObjectExporter(new JsonExportStrategy());
		$jsonData = $ormObjectExporter->exportOrmObject($user);
		$this->assertNotNull(json_decode($jsonData));
		
		// Load new user object, hydrate from JSON.
		$loadedUser = $ormService->factoryOrmObject('User');		
		$ormObjectImporter = new OrmObjectImporter(new JsonImportStrategy());
		$ormObjectImporter->importOrmObject($loadedUser, $jsonData);
		
		// Ensure the objects aren't the same instance.
		$this->assertNotSame($user, $loadedUser);
		
		// Ensure the objects are equivalent.
		$this->assertEquals($user, $loadedUser);
	}
	
	public function testOrmDataHandler()
	{
		// A user to work with.
		$user = ServiceFactoryWrapper::getService('OrmService')->factoryOrmObject('User');
		$user->setIdentifier('testOrmDataHandler-user-1');
		
		// Get the OrmDataHandler.
		$dataHandler = ServiceFactoryWrapper::getService('OrmDataHandlerService');
		
		// Save OrmObject.
		$dataHandler->saveOrmObject($user);
		
		// Load OrmObject.		
		$loadedUser = $dataHandler->loadOrmObject('User', $user->getIdentifier());
		$this->assertNotSame($user, $loadedUser);
		$this->assertEquals($user, $loadedUser);
		
		// Modify and save OrmObject.
		$loadedUser->setFirstName(new TypeString('Humberto'));
		$dataHandler->saveOrmObject($loadedUser);
		
		// Reload user.
		$reloadedUser = $dataHandler->loadOrmObject('User', $user->getIdentifier());
		$this->assertNotSame($loadedUser, $reloadedUser);
		$this->assertEquals($loadedUser, $reloadedUser);
		$this->assertEquals(new TypeString('Humberto'), $reloadedUser->getFirstName());
		
		// Delete user.
		$dataHandler->deleteOrmObject($user->getIdentifier());
		$userNoMore = $dataHandler->loadOrmObject('User', $user->getIdentifier());
		$this->assertNull($userNoMore);
	}
}