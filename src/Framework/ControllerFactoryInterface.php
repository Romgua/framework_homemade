<?php

namespace Framework;

interface ControllerFactoryInterface
{
	/**
	 * Creates an invokable controller
	 *
	 * @param array $param
	 * @return  \callable
	 */
	public function createController(array $param);
}