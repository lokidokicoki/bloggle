<?php
// src/LDC/AccountBundle/Controller/AccountController.php
namespace LDC\AccountBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use LDC\AccountBundle\Form\Type\RegistrationType;
use LDC\AccountBundle\Form\Model\Registration;

class AccountController extends Controller
{
    public function registerAction()
    {
        $form = $this->createForm(new RegistrationType(), new Registration());

        return $this->render('LDCAccountBundle:Account:register.html.twig', array('form' => $form->createView()));
    }
	public function createAction()
	{
		$dm = $this->get('doctrine_mongodb')->getManager();

		$form = $this->createForm(new RegistrationType(), new Registration());

		// NB: bindRequest is deprecated?
		//$form->bindRequest($this->getRequest());
		$form->bind($this->getRequest());

		if ($form->isValid()) {
			$registration = $form->getData();

			$dm->persist($registration->getUser());
			$dm->flush();

			return $this->redirect($this->generateUrl('ldc_bloggle_homepage'));
		}

		return $this->render('LDCAccountBundle:Account:register.html.twig', array('form' => $form->createView()));
	}
}
