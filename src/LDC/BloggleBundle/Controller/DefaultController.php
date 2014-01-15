<?php

namespace LDC\BloggleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use LDC\BloggleBundle\Document\Post;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('LDCBloggleBundle:Default:index.html.twig', array('name' => $name));
    }

	public function createAction() {
		$post = new Post();
		$post->setTitle('First Post');
		$post->setContent('First Content');

		$dm = $this->get('doctrine_mongodb')->getManager();
		$dm->persist($post);
		$dm->flush();

		return new Response('Created post id '.$post->getId());
	}
}
