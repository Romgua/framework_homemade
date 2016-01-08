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
	 */
	public function render($view, array $vars = []);

}