<?php

namespace Framework\Templating;

use Framework\Http\Response;
use Framework\Http\ResponseInterface;

class PhpRenderer implements ResponseRendererInterface
{
	private $directory;

	public function __construct($directory){
		if (!is_dir($directory)) {
			throw new \InvalidArgumentException(sprintf(
				'Directory %s does not exist.',
				$directory
			));
		}

		$this->directory = realpath($directory);
	}

	public function render($view, array $vars = []){
		$path = $this->directory.DIRECTORY_SEPARATOR.$view;
		if (!is_readable($path)) {
			throw new TemplateNotFoundException(sprintf(
				'Template "%s" cannot be found in "%s" directory',
				$view,
				$this->directory
			));
		}

		if (in_array('view', $vars)) {
			throw new \RuntimeException('The "view" template variable is a reserved keyword.');
		}

		$vars['view'] = $this;
		
		extract($vars);
		ob_start();
		include $path;

		return ob_get_clean();
	}

	public function e($vars){
		if (!is_string($vars)) {
			throw new \InvalidArgumentException('$var must be a string.');
		}

		return htmlspecialchars($vars, ENT_QUOTES);
	}

	public function renderResponse($view, array $vars = [], $statusCode = ResponseInterface::HTTP_OK){
		return new Response($statusCode, 'HTTP', '1.1', [], $this->render($view, $vars));
	}

}