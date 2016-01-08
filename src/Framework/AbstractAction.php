<?php

namespace Framework;

use Framework\ServiceLocator\ServiceLocatorInterface;

abstract class AbstractAction
{

	/**
	 * The dependency injection container.
	 * 
	 * @var ServiceLocatorInterface
	 */
	private $dic;

	public function setServiceLocator(ServiceLocatorInterface $dic){
		$this->dic = $dic;
	}

	protected function getParameter($key){
		return $this->dic->getParameter($key);
	}

	protected function getService($name){
		return $this->dic->getService($name);
	}

	protected function render($view, array $vars){
		return $this->dic->getService('renderer')->renderResponse($view, $vars);
	}

}