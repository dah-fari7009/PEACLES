<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Entity\Reservation;
use App\Repository\ReservationRepository;
use App\Entity\Restaurant;
use App\Entity\RestaurantRepository;
use App\Entity\Specialty;
use App\Entity\SpecialtyRepository;

class RestoActionController extends UserActionController{

     /**
     * @Route("/cancel_r",name="cancel_r",methods={"POST"})
     */

    public function cancelReservation(Request $request)
    {
      $idRes = $request->request.get('id');
      $em = $this->getDoctrine()->getManager();
      $oldRes = $em->getRepository(Reservation::class).find($idRes);
      $oldRes->setStatus(1);

      $newRes = new Reservation();
      $newRes->setIdClient(null);
      $newRes->setIdResto($oldRes.getIdResto());
      $newRes->setDate($oldRes.getDate());
      $newRes->setStart($oldRes.getStart());
      $newRes->setEnd($oldRes.getEnd());
      $newRes->setInfos(null);
      $newRes->setStatus(0);
      $em->persist($oldRes);
      $em->persist($newRes);
      $em->flush();
      return $this->render('page/profile.html.twig');
    }

    public static function getPrintable(Reservation $disp,$bool)
    {
      $res=['date'=>$disp->getDate()->format('Y-m-d'),'start'=>$disp->getStart()->format('H:i'),'end'=>$disp->getEnd()->format('H:i'),'id'=>$disp->getId(),'resto'=>$bool];
      return $res;
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
        $res=$this->getPrintable($disp,true);
        return $this->json($res,200,[],[]);
     }

      /**
       * @Route("/rm_avail",name="rm_avail",methods={"POST"})
       */
     public function removeAvailability(Request $request){
        $em=$this->getDoctrine()->getManager();
        $res=$em->getRepository(Reservation::class)->findOneBy(['id'=>$request->request->get('id')]);
        $em->remove($res);
        $em->flush();
        $response=array();
        return new JsonResponse($response);
     }

     /**
      * @Route("/next_avail",name="show_avail",methods={"POST"})
      */
      /*public function nextAvailaibility(Request $request){
         $em = $this->getDoctrine()->getManager();
         $date=new \DateTime($request->request->get('date'));
         //$date=\DateTime::createFromFormat("Y-m-D",$request->request->get('date'));
         $rep=$em->getRepository(Reservation::class)->findBy(["date"=>$date,"id_resto"=>$this->getU]);
         //return $this->render("page/eventcalendar.html.twig",[reservation => $res]);
         $res=array();
         foreach($rep as $disp){
            $elem=$this->getPrintable($disp);
            array_push($res,$elem);
         }
      }*/

     /**
     * @Route("/show_avail",name="show_avail",methods={"POST"})
     */

     public function showAvailabilities(Request $request){
      $em = $this->getDoctrine()->getManager();
      //$date=new \DateTime($request->request->get('date'));
      //$date=\DateTime::createFromFormat("Y-m-D",$request->request->get('date'));
      $id=$request->request->get('id');
      $bool=($this->getUser()->getId()==$id)?true:false;
      $rep=$em->getRepository(Reservation::class)->getAvailableOnDate($request->request->get('date'),$id);
      //return $this->render("page/eventcalendar.html.twig",[reservation => $res]);
      $res=array();
      foreach($rep as $disp){
         $elem=$this->getPrintable($disp,$bool);
         array_push($res,$elem);
      }
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
          return $this->render("page/specs.html.twig", ["specs" => $specs]);
      }

      /**
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
