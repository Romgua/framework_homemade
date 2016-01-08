<?php

require_once __DIR__.'/../vendor/autoload.php';

use Framework\Http\Request;
use Framework\Http\StreamableInterface;

use Framework\Kernel;
use Framework\ControllerFactory;

use Framework\Routing\Router;
use Framework\Routing\Loader\CompositeFileLoader;
use Framework\Routing\Loader\PhpFileLoader;
use Framework\Routing\Loader\XmlFileLoader;

use Framework\ServiceLocator\ServiceLocator;

use Framework\Templating\PhpRenderer;
use Framework\Templating\BracketRenderer;
use Framework\Templating\TwigRendererAdapter;

$dic = new ServiceLocator();
$dic->setParameter('app.view_dir', __DIR__.'/../app/views')
	->setParameter('router.file', __DIR__.'/../app/config/routes.xml')
	->setParameter('twig.options', [
		'cache' => __DIR__.'/../app/cache/twig',
		'debug' => true,
	])
	->register('twig', function(ServiceLocator $dic){
		return new \Twig_Environment(
		 	new \Twig_Loader_Filesystem($dic->getParameter('app.view_dir')),
			$dic->getParameter('twig.options')
		);
	})
	->register('renderer', function(ServiceLocator $dic){
		return new TwigRendererAdapter($dic->getService('twig'));
	})
	->register('router', function(ServiceLocator $dic){
		$loader = new CompositeFileLoader();
		$loader->add(new PhpFileLoader());
		$loader->add(new XmlFileLoader());

		return new Router($dic->getParameter('router.file'), $loader);
	})
	->register('controller_factory', function (ServiceLocator $dic){
		return new ControllerFactory();
	});

$kernel = new Kernel($dic);

$response = $kernel->handle(Request::createFromGlobals());

if ($response instanceof StreamableInterface) {
	$response->send();
}