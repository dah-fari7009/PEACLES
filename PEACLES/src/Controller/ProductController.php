<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="product")
     */
    public function index()
    {
        $restoid = $this->getUser()->getUsername();
        $menu = array();
        $em = $this->getDoctrine()->getManager();
        $rest = $em->getRepository(Restaurant::class).findBy($restoid);
        for ($i = 1; $i <= 4; $i++) {
          array_push($menu, $menu.getProductsByType($i));
        }
        return $this->render('page/menu.html.twig', [
            'products' => $menu,
        ]);
    }

    /**
     * @Route("/addproduct", name="addproduct", methods={"POST"})
     */
    public function addProduct(Request $request)
    {
        $restoid = $this->getUser()->getIdResto();
        $pname=$request->request->get('p_name');
        $price=$request->request->get('price');
        $type=$request->request->get('type');
        $prod = new Product();
        $prod->setType($type);
        $prod->setIdResto($restoid);
        $prod->setName($pname);
        $prod->setPrice($price);
        $em = $this->getDoctrine()->getManager();
        $em->persist($prod);
        $em->flush();
        return $this->json([$prod], 200, [], ['groups' => ['bts']]);
    }

    /**
     * @Route("/delproduct", name="delproduct", methods={"POST"})
     */
    public function delProduct(Request $request)
    {
        $idprod = $request->request->get("id_prod");
        $em = $this->getDoctrine()->getManager();
        $prod = $em->getRepository(Product::class).findOneBy(['id' => $idprod]);
        $em->remove($prod);
        $em->flush();
        $reponse = array();
        return new JsonResponse($reponse);
    }



}
