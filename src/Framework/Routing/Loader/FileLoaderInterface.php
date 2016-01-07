<?php

namespace Framework\Routing\Loader;

interface FileLoaderInterface
{

	/**
	 * Loads a routing configuration file.
	 *
	 * @param  String $path The configuration file path
	 * @return  RouteCollection
	 */
	public function load($path);
}