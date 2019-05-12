<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Entity\Reservation;


class RestoActionController extends UserActionController{

     /**
     * @Route("/cancel_r",name="cancel_r",methods={"POST"})
     */

    public function cancelReservation(Request $request)
    {
      $idRes = $request->request.get('item.id');
      $em = $this->getDoctrine()->getManager();
      $oldRes = $em->getRepository(Reservation::class).findBy($idRes);
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
     * @Route("/add_avail",name="add_avail",methods={"POST"})
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
        $res=['date'=>$disp->getDate()->format('Y-m-d'),'start'=>$disp->getStart()->format('H:i'),'end'=>$disp->getEnd()->format('H:i'),'id'=>$disp->getId(),'resto'=>true];
        return $this->json($res,200,[],[]);
     }

      /**
       * @Route("/rm_avail",name="rm_avail",methods={"POST"})
       */
     public function removeAvailability(Request $request){
        $em=$this->getDoctrine()->getManager();
        $em->remove($em->getRepository(Reservation::class)->find($request->request->get('id')));
        $em->flush();
        $response=array();
        return new JsonResponse($response);
     }

     /**
     * @Route("/show_avail",name="show_avail",methods={"POST"})
     */

     public function showAvailabilities(Request $request){
      $em = $this->getDoctrine()->getManager();
      $date=new \DateTime($request->request->get('date'));
      //$date=\DateTime::createFromFormat("Y-m-D",$request->request->get('date'));
      $res=$em->getRepository(Reservation::class)->findBy(["date"=>$date,"id_resto"=>$this->getUser()->getId()]);
      //return $this->render("page/eventcalendar.html.twig",[reservation => $res]);
      return $this->json($res,200,[],['groups' => ['group1']]);
      /*$response = array(
         "code" =>"200",
         "response" => $this->render('page/reservationsample.html.twig',['reservations' => $res])->getContent());
        return new JsonResponse($response);*/
     }

    /**
     * @Route("/set",name="set")
     */

     public function setAvailabilities(Request $request)
     {
         //return $this->render("page/eventcalendar.html.twig");
     }

     /**
      * @Route("/specs",name="specs")
      */

      public function showSpecs(Request $request)
      {
          $em = $this->getDoctrine()->getManager();
          $specs = $em->getRepository(Specialty::class)->findAll();
          return $this.render("page/specs.html.twig", ["specs" => $specs]);
      }

      /**addSpecialty
       * @Route("/addspecs",name="addspecs", methods={"POST"})
       */

       public function setSpecs(Request $request)
       {
           $rest = $this->getUser();
           $em = $this->getDoctrine()->getManager();
           $input = $request->request->get('spec');

           $min_age = $request->request->get("min_age");
           $min = $request->request->get("min");
           $max = $request->request->get("max");
           $rest->setMinAge($min_age);
           $rest->setMinSeats($min);
           $rest->setMaxSeats($max);

           foreach($input as $elem){
             $s = $em->getRepository(Specialty::class)->find($elem);
             $rest->addSpecialty($s);
           }
           $em->persist($rest);
           $em->flush();
           return $this.render("page/profile.html.twig");
       }


}
?>
