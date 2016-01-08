<?php

namespace Framework\Templating;

use Framework\Response;
use Framework\ResponseInterface;

interface ResponseRendererInterface extends RendererInterface
{

	/**
	 * Evaluate a template view file and returns a Response instance.
	 * 
	 * @param  String $view 		The template filename
	 * @param  array  $vars 		The view variable
	 * @param  int 	  $statusCode 	The response status code
	 * @return Response 
	 */
	public function renderResponse($view, array $vars = [], $statusCode = ResponseInterface::HTTP_OK);

}