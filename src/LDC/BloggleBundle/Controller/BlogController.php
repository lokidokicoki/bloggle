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

	public function newAction($bad=NULL) {
		$form = $this->createFormBuilder()
			->setAction($this->generateUrl('ldc_bloggle_created'))
			->setMethod('POST')
            ->add('title', 'text')
            ->add('save', 'submit')
            ->getForm();

        return $this->render('LDCBloggleBundle:Blog:new.html.twig', array(
            'form' => $form->createView(),
			'bad' => $bad
        ));
	}

	public function createdAction() {
		$dm = $this->get('doctrine_mongodb')->getManager();
		$repo = $dm->getRepository('LDCBloggleBundle:Blog');
		$request = $this->getRequest();

		// get blog title from request
		$title = $request->request->get('form')['title'];

		// check if already exists
		if ($repo->findOneByTitle(array('title'=>$title))){
			return $this->newAction($title);
		}else{
			$blog = new Blog();
			$blog->setTitle($title);

			$dm = $this->get('doctrine_mongodb')->getManager();
			$dm->persist($blog);
			$dm->flush();
			//return $this->redirect($this->generateUrl('ldc_bloggle_blog', array('id' => $blog->getId())));
			return $this->blogAction($blog->getTitle());
		}
	}

	public function blogAction($title) {
		$logger = $this->get('logger');
		$dm = $this->get('doctrine_mongodb')->getManager();
		$repo = $dm->getRepository('LDCBloggleBundle:Blog');
		$blog = $repo->findOneByTitle($title);
		$posts = $blog->getPosts()->toArray();
		usort($posts, function($a, $b) {
			if ($a->getCreated() > $b->getCreated()) {
				return -1;
			}
		});
		$blog->setPosts($posts);
/*
		foreach ($posts as $post){
			print_r($post);
		}
		unset($post);
 */

		return $this->render('LDCBloggleBundle:Blog:blog.html.twig', array('blog' => $blog));
	}

}
