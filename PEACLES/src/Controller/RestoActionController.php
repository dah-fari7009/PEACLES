<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Reservation;


class RestoActionController extends UserActionController{

     /**
     * @Route("/cancel_r",name="cancel_r",methods={"POST"})
     */

    public function cancelReservation(Request $request)
    {
      $idRes = $request->request.get('item.id');
      $em = $this->getDoctrine()->getManager();
      $oldRes = $em->getRepository(Reservation::class).findby($idRes);
      $oldRes.setStatus(1);

      $newRes = new Reservation();
      $newRes.setIdClient(null);
      $newRes.setIdResto($oldRes.getIdResto());
      $newRes.setDate($oldRes.getDate());
      $newRes.setStart($oldRes.getStart());
      $newRes.setEnd($oldRes.getEnd());
      $newRes.setInfos(null);

      $em->persist($oldRes);
      $em->persist($newRes);
      $em->flush();
      return $this->render('page/profile.html.twig');
    }

    /**
     * @Route("/set",name="set")
     */

     public function setAvailabilities(Request $request)
     {

     }





}
?>
