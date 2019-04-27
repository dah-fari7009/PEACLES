<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class UserActionController extends AbstractController{
    /**
     * @Route("/update_bio",name="updatebio",methods={"POST"})
     */

    public function updateBio(Request $request)
    {
        //return $this->render("page/.html.twig");
    }

    
    /**
     * @Route("/upload",name="upload",methods={"POST"})
     */

     public function uploadpicture(Request $request)
     {
         //return $this->render("page/.html.twig");
     }

     /**
     * @Route("/remove",name="remove",methods={"POST"})
     */

    public function removePicture(Request $request)
    {
        //return $this->render("page/.html.twig");
    }

    /**
     * @Route("/upload",name="upload",methods={"POST"})
     */

     /**
      * @Route("/change_pp",name="changepp",methods={"POST"})
      */

      public function change_pp(Request $request){

      }

    
}
?>