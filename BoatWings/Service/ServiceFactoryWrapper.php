<?php
namespace BoatWings\Service;

abstract class ServiceFactoryWrapper 
{
	private static $serviceFactory;
	
	public static function setServiceFactory(ServiceFactory $serviceFactory)
	{
		self::$serviceFactory = $serviceFactory;
	}
	
	public static function getService($serviceName)
	{
		return self::$serviceFactory->getService($serviceName);
	}
}