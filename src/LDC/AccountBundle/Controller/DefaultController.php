<?php

namespace LDC\AccountBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('LDCAccountBundle:Default:index.html.twig', array('name' => $name));
    }
}
