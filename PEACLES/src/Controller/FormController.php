<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
}
