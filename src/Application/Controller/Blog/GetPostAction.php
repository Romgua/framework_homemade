<?php

namespace Application\Controller\Blog;

use Framework\AbstractAction;
use Framework\Http\Request;
use Framework\Http\HttpNotFoundException;

class GetPostAction extends AbstractAction
{

	public function __invoke(Request $request){
		$repository = $thus->getService('repository.blog_post');

		$id = $request->getAttribute('id');
		if (!$post = $repository->find($id)) {
			throw new HttpNotFoundException(sprintf(
				'No blog post found for id #%u',
				$id
			));
		}

		return $this->render('blog/show.twig', [
			'post' => $post,
		])
	}

}