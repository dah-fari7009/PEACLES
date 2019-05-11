<?php

namespace App\Controller;

use App\Entity\Picture;
use App\Entity\User;
use App\Form\PictureType;
use App\Service\FileHandler;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class UserActionController extends AbstractController{

    /**
     * @Route("/upload",name="upload")
     */

     public function uploadpicture(Request $request)
     {
        $pic = new Picture();
        $form = $this->createForm(PictureType::class, $pic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $pic->getImgUrl();

            $fileName = $fileHandler->upload($file);

            // Move the file to the images directory
            try {
                $file->move(
                    $this->getParameter('user_images_directory'),
                    $fileName
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            $pic->setImgUrl($fileName);

            // ... persist the $pic variable or any other work

            return $this->redirect($this->generateUrl('profile'));
        }

        return $this->render('form/upload_pic.html.twig', [
            'form' => $form->createView(),
        ]);
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
        $new = $request->getContent();
        $file = $new->getImgUrl();
        $fileName = $fileHandler->upload($file);
        echo($filename);
        try {
            $file->move(
                $this->getParameter('user_images_directory'),
                $fileName
            );
        } catch (FileException $e) {
        }
        $new->setImgUrl($fileName);
        $username = $this->getUser()->getUsername();
        $em = $this->getDoctrine()->getManager();
        $usr = $em->getRepository(User::class).findOneBy($username);
        echo($filename);
        $usr.setProfilePic($filename);
        $em->persist($usr);
        $em->flush();
        return $this->render('page/profile.html.twig');
      }


}
?>
