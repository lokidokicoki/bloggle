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
	public function postAction($title, $bad=NULL) {
		$form = $this->createFormBuilder()
			->setAction($this->generateUrl('ldc_bloggle_posted', array('title'=>$title)))
            ->add('title', 'text')
            ->add('content', 'textarea')
            ->add('save', 'submit')
            ->getForm();

        return $this->render('LDCBloggleBundle:Post:new.html.twig', array(
            'form' => $form->createView()
        ));
	}

	public function postedAction($title) {
		$logger = $this->get('logger');
		$post = new Post();

		$dm = $this->get('doctrine_mongodb')->getManager();
		$repo = $dm->getRepository('LDCBloggleBundle:Blog');
		$blog = $repo->findOneByTitle($title);

		$request = $this->getRequest();

		// get blog title from request
		$post->setTitle($request->request->get('form')['title']);
		$post->setContent($request->request->get('form')['content']);
		$post->setCreated(new MongoDate());

		$dm->persist($post);

		$blog->addPost($post);
		$dm->flush();

		return $this->redirect($this->generateURL('ldc_bloggle_blog', array('title'=>$title)));
	}
}
