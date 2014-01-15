<?php

namespace LDC\BloggleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('LDCBloggleBundle:Default:index.html.twig', array('name' => $name));
    }
}
