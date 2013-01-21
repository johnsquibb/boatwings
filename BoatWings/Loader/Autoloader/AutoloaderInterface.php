<?php
namespace BoatWings\Loader\Autoloader;

interface AutoloaderInterface 
{
	public function loadClass($className);
}