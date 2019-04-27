<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SignupController extends AbstractController{
    /**
     * @Route("/signup",name="signup")
     */

     public function signup()
     {
         return $this->render("page/signup.html.twig");
     }
}
?>