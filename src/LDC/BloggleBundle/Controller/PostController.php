<?php

namespace LDC\BloggleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use LDC\BloggleBundle\Document\Blog;
use LDC\BloggleBundle\Document\Post;
use Symfony\Component\HttpFoundation\Response;
use MongoDate;
use DateTime;

class PostController extends Controller
{
	public function postAction($title) {
		$logger = $this->get('logger');
		$post = new Post();

		$dm = $this->get('doctrine_mongodb')->getManager();
		$repo = $dm->getRepository('LDCBloggleBundle:Blog');
		$blog = $repo->findOneByTitle($title);

		$post->setTitle("My title");
		$post->setContent("My content");
		$post->setCreated(new MongoDate());

		$dm->persist($post);

		$blog->addPost($post);
		$dm->flush();

		return $this->render('LDCBloggleBundle:Post:post.html.twig', array('post' => $post, 'blog' => $blog));
	}
}
