<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use App\Security\LoginAuthenticator;
use App\Entity\Client;
use App\Form\ClientType;
use App\Entity\Restaurant;
use App\Form\RestoType;

class FormController extends AbstractController
{

    /**
     * @Route("/signup_c", name="signupc")
     */
    public function signClientUp(Request $request, UserPasswordEncoderInterface $passwordEncoder,GuardAuthenticatorHandler $guardHandler, LoginAuthenticator $authenticator)
    {
        $user=new Client();
        $user->setBday(new \DateTime('tomorrow'));
        
        $form=$this->createForm(ClientType::class,$user);

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
            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main'
            );
        }
        return $this->render('form/signup_form.html.twig',[
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/signup_r",name="signupr")
     */
    public function signRestoUp(Request $request, UserPasswordEncoderInterface $passwordEncoder,GuardAuthenticatorHandler $guardHandler, LoginAuthenticator $authenticator)
    {
        $user=new Restaurant();
        //$user->setBday(new \DateTime('tomorrow'));
        
        $form=$this->createForm(RestoType::class,$user);

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
            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main'
            );
        }
        return $this->render('form/signup_form.html.twig',[
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/modify")
     */

     public function modify(Request $request){

     }
  }
