<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\UserType;
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

    /**
     * @Route("/signup")
     */
    public function signup(Request $request)
    {
        $user=new User();
        $user.setName('');
        $user.setEmail('');
        $user.setPwd('');
        $user->setBday(new \DateTime('tomorrow'));
        $user.setPhone('');
        
        $form=$this->createForm(UserType::class,$user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            dump($user);
        }
        return $this->render('form/signup.html.twig',array(
            'form' => $form->createView(),
        ));
    }
      
  }
