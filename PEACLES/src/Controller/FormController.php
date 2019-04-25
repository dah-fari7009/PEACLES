<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
//use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\User;
use App\Form\UserType;
use App\Form\AuthType;
use App\Entity\Auth;

class FormController extends AbstractController
{
    /**
     * @Route("/signup")
     */
    public function signup(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user=new User();
        $user->setBday(new \DateTime('tomorrow'));
        
        $form=$this->createForm(UserType::class,$user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            //encode the password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            //everything else needed here
            //redirection and sending emails for instance
        }
        return $this->render('form/signup.html.twig',[
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/modify")
     */
      
     public function modify(Request $request){

     }
  }
