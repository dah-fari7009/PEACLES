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
use App\Entity\ReservationInfos;
use App\Entity\Reservation;


class ClientActionController extends UserActionController{

    /**
     * @Route("/book",name="book")
     */

     public function booking(Request $request){
       $res=$this->getDoctrine()->getManager()->getRepository(Restaurant::class)->find($request->get("resto"));
       //$avail=$res->getAvailabilities();
       return $this->render("page/book.html.twig",["resto"=>$res]);
     }


    /**
     * @Route("/make_r",name="maker",methods={"POST"})
     */

     public function makeReservation(Request $request)
     {
         $client= $this->getUser();
         $idRes = $request->request->get('id');
        $em = $this->getDoctrine()->getManager();
        $res = $em->getRepository(Reservation::class)->find($idRes);
        $res->setIdClient($client);
        $em->persist($res);
        $em->flush();
        return new JsonResponse(array());

     }

     /**
     * @Route("/cancel_r",name="cancelr",methods={"POST"})
     */
    public function cancelReservation(Request $request)
    {
      $idRes = $request->request.get('item.id');
      $em = $this->getDoctrine()->getManager();
      $res = $em->getRepository(Reservation::class)->findOneBy($idRes);
      $res->setIdClient(null);
      $em->persist($res);
      $em->flush();
      return new JsonResponse(array());
    }

    /**
     * @Route("/complete",name="complete",methods={"POST"})
    */
    public function complete(Request $request)
    {
        $key= $request->request->get('key');
        $keys=explode(" ",$request->request->get('key'));
        $spec=[];
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

    /**
    * @Route("/closest",name="closest",methods={"POST"})
    */
   public function searchCloseRestaurants(Request $request)
   {
     $long= $request->request->get('longitude');
     $lat= $request->request->get('latitude');
     $em = $this->getDoctrine()->getManager();
     $res = $em->getRepository(Restaurant::class)->findClosestRestos($long, $lat);
     return $this->render("page/results.html.twig",["results" => $res]);
   }
}

//il faut, chercher ce qui satisfait la requete, ensuite chercher parmi les résultats de la requete à chaque fois
?>
