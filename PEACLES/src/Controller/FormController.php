<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use App\Security\LoginAuthenticator;
use App\Entity\Client;
use App\Entity\User;
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
     * @Route("/modify",name="modify")
     */

     public function modify(Request $request){
       $old = $this.getUser();
       if($old instanceof Client){
         $em = $this->getDoctrine()->getManager();
         $user = $em->getRepository(Client::class).findby($old.getId());
         $form=createForm(ClientType::class, $user);
         $form->handleRequest($request);
         if($form->isSubmitted() && $form->isValid()){
             $em->persist($user);
             $em->flush();
             return $guardHandler->authenticateUserAndHandleSuccess(
                 $user,
                 $request,
                 $authenticator,
                 'main'
             );
         }
         return $this->render('form/modify.html.twig',[
             'form' => $form->createView(),
         ]);
       }
       if($old instanceof Restaurant){
         $em = $this->getDoctrine()->getManager();
         $user = $em->getRepository(Restaurant::class).findby($old.getId());
         $form=createForm(RestoType::class, $user);
         $form->get('email')->setData($user.getEmail());
         $form->handleRequest($request);
         if($form->isSubmitted() && $form->isValid()){
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
         return $this->render('form/modify.html.twig',[
             'form' => $form->createView(),
         ]);
       }

     }

     /**
      * @Route("/setup",name="setup")
      */
     public function setup(Request $request){
         return $this->render('page/eventcalendar.html.twig');
     }
  }
