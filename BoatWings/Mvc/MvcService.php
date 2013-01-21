<?php
namespace BoatWings\Mvc;

class MvcService 
{
	public function executeControllerActionContext($controllerClass, $actionContext, array $actionParameters)
	{
		if (class_exists($controllerClass))
		{
			$controller = new $controllerClass(
				$actionContext,
				$actionParameters
			);
			
			if ($controller instanceof ControllerInterface)
			{
				$controller->processAction();
				$actionResult = $controller->getActionResult();

				return $actionResult;
			}
			else
			{
				throw new \Exception("Invalid controller. Class '{$controllerClass}' does not implement ControllerInterface.");
			}
		}
		else
		{
			throw new \Exception("Invalid controller. Class '{$controllerClass}' does not exist.");
		}
	}
	
	public function executeModelDataContext($modelClass, $dataContext, array $dataParameters)
	{
		if (class_exists($modelClass))
		{
			$model = new $modelClass(
				$dataContext,
				$dataParameters
			);

			if ($model instanceof ModelInterface)
			{
				$model->processData();
				$dataResult = $model->getDataResult();
			}
			else
			{
				throw new \Exception("Invalid model. Class '{$modelClass}' does not implement ModelInterface.");
			}
			
			return $dataResult;
		}
		else
		{
			throw new \Exception("Invalid model. Class '{$modelClass}' does not exist.");
		}
	}
	
	public function executeViewRenderContext($viewClass, $renderContext, array $renderParameters)
	{
		if (class_exists($viewClass))
		{
			$view = new $viewClass(
				$renderContext,
				$renderParameters
			);

			if ($view instanceof ViewInterface)
			{
				$view->processRender();
				$viewResult = $view->getRenderResult();

				return $viewResult;
			}
			else
			{
				throw new \Exception("Invalid view. Class '{$viewClass}' does not implement ViewInterface.");
			}
		}
		else
		{
			throw new \Exception("Invalid view. Class '{$viewClass}' does not exist.");
		}
	}
}