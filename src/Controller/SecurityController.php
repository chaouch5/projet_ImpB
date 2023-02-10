<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="app_registration")
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {

        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $hash = $encoder->encodePassword($user, $user->getPassword());

            $user->setPassword($hash);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();


        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);
       
    }




     /**
     * @Route("/", name="app_login")
     */
    public function login()
    {

        
        return $this->render('security/login.html.twig');
        //return $this->redirectToRoute('app_home');


    }




      /**
     * @Route("/logout", name="app_logout")
     */
    public function logoout()
    {

    }



}
