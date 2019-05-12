<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Entity\Restaurant;

class ProfileController extends AbstractController{
    /**
     * @Route("/profile",name="profile")
     */

     public function show_profile(Request $request)
     {
         if($this->getUser() instanceof Restaurant)
            return $this->render("page/profile.html.twig",['user'=>$this->getUser()]);
         if($request->get('searched')){
             $rest=new Restaurant();
             $em=$this->getDoctrine()->getManager();
             $rest=$em->getRepository(Restaurant::class)->find($request->get('id'));
             return $this->render("page/profile.html.twig",['user'=>$rest]);
         }
         return new RedirectResponse($this->generateUrl('index'));
         
     }
}
?>
