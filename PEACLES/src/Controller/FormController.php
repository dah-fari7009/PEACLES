<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\UserType;

class FormController extends AbstractController
{
    /**
     * @Route("/signin", name="signin")
     */
    public function index()
    {
        

        return $this->render('form/signin.html.twig', [
            'controller_name' => 'FormController',
        ]);
    }

    /**
     * @Route("/signup)
     */
    public function signup(Request $request)
    {
        $user=new User();
        $user->setBday(new \DateTime('tomorrow'));
        
        $form=$this->createForm(UserType::class,$user);

        return $this->render('form/signup.html.twig',array(
            'form' =>$form->createView();
        ))
    }
}
