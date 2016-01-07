<?php

use Framework\Routing\Route;
use Framework\Routing\RouteCollection;

$routes = new RouteCollection();
$routes->add('hello', new Route(
	'/hello',
	[ 
		'_controller' => 'Application\Controller\HelloWorldAction',
	]
));

return $routes;