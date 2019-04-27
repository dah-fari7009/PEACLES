<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ClientActionController extends UserActionController{
    /**
     * @Route("/make_r",name="maker",methods={"POST"})
     */

     public function makeReservation(Request $request)
     {
         //return $this->render("page/.html.twig");
     }

     /**
     * @Route("/cancel_r",name="cancelr",methods={"POST"})
     */

    public function cancelReservation(Request $request)
    {
        //return $this->render("page/.html.twig");
    }

    
    
}
?>