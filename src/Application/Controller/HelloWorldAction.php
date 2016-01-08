<?php

namespace Application\Controller;

use Framework\Http\RequestInterface;
use Framework\AbstractAction;

final class HelloWorldAction extends AbstractAction
{

	public function __invoke(RequestInterface $request){
		return $this->render('hello.twig', [
			'name' => 'romain'
		 ]);
	}

}