<?php

namespace LDC\BloggleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use LDC\BloggleBundle\Document\Blog;
use LDC\BloggleBundle\Document\Post;
use Symfony\Component\HttpFoundation\Response;
use MongoDate;
use DateTime;

class DefaultController extends Controller
{
    public function indexAction() {
		$dm = $this->get('doctrine_mongodb')->getManager();
		$repo = $dm->getRepository('LDCBloggleBundle:Blog');
		$blogs = $repo->findAll();
        return $this->render('LDCBloggleBundle:Default:index.html.twig', array('blogs' => $blogs));
    }

	public function newblogAction() {
		$blog = new Blog();
		$blog->setTitle('New Blog');

		$dm = $this->get('doctrine_mongodb')->getManager();
		$dm->persist($blog);
		$dm->flush();
		//return $this->redirect($this->generateUrl('ldc_bloggle_blog', array('id' => $blog->getId())));
		return $this->blogAction($blog->getId());
	}

	public function postAction($id) {
		$logger = $this->get('logger');
		$post = new Post();

		$dm = $this->get('doctrine_mongodb')->getManager();
		$repo = $dm->getRepository('LDCBloggleBundle:Blog');
		$blog = $repo->find($id);

		$post->setTitle("My title");
		$post->setContent("My content");
		$post->setCreated(new MongoDate());

		$dm->persist($post);

		$blog->addPost($post);
		$dm->flush();

		return $this->render('LDCBloggleBundle:Default:post.html.twig', array('post' => $post, 'blog' => $blog));
	}

	public function blogAction($id) {
		$logger = $this->get('logger');
		$dm = $this->get('doctrine_mongodb')->getManager();
		$repo = $dm->getRepository('LDCBloggleBundle:Blog');
		$blog = $repo->find($id);
/*
		foreach ($posts as $post){
			print_r($post);
		}
		unset($post);
 */

		return $this->render('LDCBloggleBundle:Default:blog.html.twig', array('blog' => $blog));
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
