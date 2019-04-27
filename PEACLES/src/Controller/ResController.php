<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ResController extends AbstractController{

    public function get_history()
     {
         return $this->getUser()->getReservationHistory();
     }

     public function get_future()
     {
         return $this->getUser()->getUpcomingReservations();
     }

    /**
     * @Route("/reservation",name="reservation")
     */

     public function show_reservations()
     {
         $past=$this->get_history();
         $future=$this->get_future();
         return $this->render("page/book.html.twig",["past" => $past, "future" => $future ]);
     }

     


     /** 
      * @Route("/book", name="book")
      */

      public function bookRestaurant(){
        return $this->render("index/index.html.twig");
      }
}
?>