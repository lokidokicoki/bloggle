<?php

namespace LDC\BloggleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use LDC\BloggleBundle\Document\Blog;
use LDC\BloggleBundle\Document\Post;
use Symfony\Component\HttpFoundation\Response;
use MongoDate;
use DateTime;

class BlogController extends Controller
{
    public function indexAction() {
		$dm = $this->get('doctrine_mongodb')->getManager();
		$repo = $dm->getRepository('LDCBloggleBundle:Blog');
		$blogs = $repo->findAll();
        return $this->render('LDCBloggleBundle:Blog:index.html.twig', array('blogs' => $blogs));
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

		return $this->render('LDCBloggleBundle:Blog:blog.html.twig', array('blog' => $blog));
	}

}
