<?php

namespace Framework\Templating;

interface RendererInterface
{

	/**
	 * Evaluate a template view file.
	 * 
	 * @param  String $view The template filename
	 * @param  array  $vars The view variable
	 * 
	 * @return String 
	 *
	 * @throws TemplateNotFoundException When template does not exist
	 */
	public function render($view, array $vars = []);

}