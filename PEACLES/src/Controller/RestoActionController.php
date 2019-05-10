<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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
      $oldRes.setStatus(3);

      $newRes = new Reservation();
      $newRes.setIdClient(null);
      $newRes.setIdResto($oldRes.getIdResto());
      $newRes.setDate($oldRes.getDate());
      $newRes.setStart($oldRes.getStart());
      $newRes.setEnd($oldRes.getEnd());
      $newRes.setStatus(0);
      $newRes.setInfos(null);

      $em->persist($oldRes);
      $em->persist($newRes);
      $em->flush();
      return;
    }

    /**
     * @Route("/add_avail",name="add_avail")
     */

     public function addAvailability(Request $request){
        $disp=new Reservation();
        $disp->setIdResto($this->getUser());
        $disp->setDate(new \DateTime($request->request->get('date')));
        $disp->setStart(new \DateTime($request->request->get('start')));
        $disp->setEnd(new \DateTime($request->request->get('end')));
        $disp->setStatus(0);
        $em = $this->getDoctrine()->getManager();
        $em->persist($disp);
        $em->flush();
        return new Response();
        //return $this->render("page/eventcalendar.html.twig");
     }

     public function removeAvailability(Request $request){
        $em=$this->getDoctrine()->getManager();
        $em->remove($em->getRepository(Reservation::class).find($request->request->get('id')));
        $em->flush();
        return new Response();
     }

     /**
     * @Route("/show_avail",name="show_avail")
     */

     public function showAvailabilities(Request $request){
      $em = $this->getDoctrine()->getManager();
      $date=new \DateTime($request->request->get('date'));
      //$date=\DateTime::createFromFormat("Y-m-D",$request->request->get('date'));
      $res=$em->getRepository(Reservation::class)->findBy(["date"=>$date,"id_resto"=>$this->getUser()->getId()]);
      //return $this->render("page/eventcalendar.html.twig",$res);
      return $this->json($res,200,[],['groups' => ['group1']]);
        
     }

    /**
     * @Route("/set",name="set")
     */

     public function setAvailabilities(Request $request)
     {
         return $this->render("page/eventcalendar.html.twig");
     }





}
?>
