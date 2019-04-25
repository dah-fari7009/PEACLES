<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\AuthType;
use App\Entity\Auth;

class FormController extends AbstractController
{
  /**
   * @Route("/signin")
   */
  public function signin(Request $request)
  {
      $auth = new Auth();
      $auth->setEmail('');
      $auth->setPwd('');

      $form = $this->createForm(AuthType::class, $auth);

      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
          dump($auth);
      }

      return $this->render('form/login.html.twig', array(
          'form' => $form->createView(),
      ));
  }
}
