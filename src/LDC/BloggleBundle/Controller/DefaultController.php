<?php

namespace LDC\BloggleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use LDC\BloggleBundle\Document\Post;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction($name) {
        return $this->render('LDCBloggleBundle:Default:index.html.twig', array('name' => $name));
    }

	public function createAction() {
		$post = new Post();
		$post->setTitle('First Post');
		$post->setContent('First Content');
		$post->setCreated(new \MongoDate());

		$dm = $this->get('doctrine_mongodb')->getManager();
		$dm->persist($post);
		$dm->flush();

		return $this->render('LDCBloggleBundle:Default:post.html.twig', array('post' => $post));
	}

	public function blogAction() {
		$dm = $this->get('doctrine_mongodb')->getManager();
		$repo = $dm->getRepository('LDCBloggleBundle:Post');
		$posts = $repo->findAll();

		foreach ($posts as $post){
			if (is_null($post->getCreated())){
				$post->setCreated(new \MongoDate());
				$dm->flush();
			}
		}
		unset($post);

		return $this->render('LDCBloggleBundle:Default:blog.html.twig', array('posts' => $posts));
	}
}
