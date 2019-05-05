<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use App\Entity\Specialty;
use App\Entity\Restaurant;

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
      $idRes = $request->request.get('item.id');
      $em = $this->getDoctrine()->getManager();
      $res = $em->getRepository(Reservation::class).findby($idRes);
      $res.setStatus(0);
      $res.setIdClient(null);
      $em->persist($res);
      $em->flush();
      return;
    }

    /**
     * @Route("/complete",name="complete",methods={"POST"})
    */
    public function complete(Request $request)
    {
        $key= $request->request->get('key');
        $keys=explode(" ",$request->request->get('key'));
        $spec=$this->getDoctrine()
        ->getRepository(Specialty::class)
         ->searchByCuisine($key);
        $results=$this->getDoctrine()
            ->getRepository(Restaurant::class)
            ->searchMultiple($keys);
        return $this->json([$spec,$results],200,[],['groups' => ['group1']]);
    }

    /**
     * @Route("/search",name="search")
     */
    public function search(Request $request)
    {
       $keys=explode(" ",$request->request->get('key'));
       $results=$this->getDoctrine()
            ->getRepository(Restaurant::class)
            ->searchMultiple($keys);
    return $this->render("page/results.html.twig",["results" => $results]);
    }
}

//il faut, chercher ce qui satisfait la requete, ensuite chercher parmi les résultats de la requete à chaque fois
?>
