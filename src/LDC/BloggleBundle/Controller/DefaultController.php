<?php

namespace LDC\BloggleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use LDC\BloggleBundle\Document\Post;
use Symfony\Component\HttpFoundation\Response;
use MongoDate;
use DateTime;

class DefaultController extends Controller
{
    public function indexAction($name) {
        return $this->render('LDCBloggleBundle:Default:index.html.twig', array('name' => $name));
    }

	public function createAction() {
		$logger = $this->get('logger');
		$post = new Post();
		$post->setTitle("My title");
		$post->setContent("My content");
		$post->setCreated(new MongoDate());

		$dm = $this->get('doctrine_mongodb')->getManager();
		$dm->persist($post);
		$dm->flush();


		$bob = $dm->getRepository('LDCBloggleBundle:Post')->find($post->getId());

		print_r($bob);
		return $this->render('LDCBloggleBundle:Default:post.html.twig', array('post' => $bob));
	}

	public function blogAction() {
		$logger = $this->get('logger');
		$dm = $this->get('doctrine_mongodb')->getManager();
		$repo = $dm->getRepository('LDCBloggleBundle:Post');
		$posts = $repo->findAll();
/*
		foreach ($posts as $post){
			print_r($post);
		}
		unset($post);
 */

		return $this->render('LDCBloggleBundle:Default:blog.html.twig', array('posts' => $posts));
	}

	public function purgeAction() {
		$dm = $this->get('doctrine_mongodb')->getManager();
		$repo = $dm->getRepository('LDCBloggleBundle:Post');
		$posts = $repo->findAll();

		foreach ($posts as $post){
			$dm->remove($post);
		}
		$dm->flush();

		return $this->render('LDCBloggleBundle:Default:blog.html.twig', array('posts' => array()));
	}
}
