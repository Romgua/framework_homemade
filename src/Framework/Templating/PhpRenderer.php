<?php

namespace Framework\Templating;

use Framework\Http\Response;
use Framework\Http\ResponseInterface;

class PhpRenderer extends AbstractRenderer
{
	
	public function render($view, array $vars = []){
		$path = $this->getTemplatePath($view);

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

}