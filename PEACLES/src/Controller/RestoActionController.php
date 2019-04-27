<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class RestoActionController extends UserActionController{
    /**
     * @Route("/accept_r",name="acceptr",methods={"POST"})
     */

     public function acceptReservation(Request $request)
     {
         //return $this->render("page/.html.twig");
     }

     /**
     * @Route("/refuse_r",name="refuser",methods={"POST"})
     */

    public function refuseReservation(Request $request)
    {
        //return $this->render("page/.html.twig");
    }

    /**
     * @Route("/set",name="set")
     */

     public function setAvailabilities(Request $request)
     {

     }

     


    
}
?>