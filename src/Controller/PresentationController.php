<?php

namespace App\Controller;

use App\Entity\Actualité;
use App\Entity\Presentation;
use App\Form\PresentationType;
use App\Form\EditPresentationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PresentationController extends AbstractController
{
    /**
     * @Route("/presentation", name="app_presentation")
     */
    public function index(): Response
    {
        return $this->render('presentation/index.html.twig', [
            'controller_name' => 'PresentationController',
        ]);
    }

    //ADD

    /**
     * @Route("/addPres", name="addPres")
     */
    public function addPres(Request $request): Response
    {
        $pres = new Presentation();
        $form = $this->createForm(PresentationType::class, $pres);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('photo')->getData();
            foreach ($image as $ima) {
                $fichier = md5(uniqid()) . '.' . $ima->guessExtension();
                $ima->move(
                    $this->getParameter('img_directory'),
                    $fichier
                );
            }
            $em = $this->getDoctrine()->getManager();
            $pres->setPhoto($fichier);
            $em->persist($pres);
            $em->flush();

            return $this->redirectToRoute('display_pres');
        }
        return $this->render('presentation/addPresentation.html.twig', ['form' => $form->createView()]);
    }

    //DISPLAY
    /**
     * @Route("/display_pres", name="display_pres")
     */
    public function displayPres(): Response
    {
        $pres = $this->getDoctrine()->getManager()->getRepository(Presentation::class)->findAll();
        return $this->render('presentation/index.html.twig', [
            'pres'=>$pres
        ]);
    }

    //delete
    /**
     * @Route("/suppPres/{id}", name="suppPres")
     */
    public function deletePres(Presentation  $pres): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($pres);
        $em->flush();

        return $this->redirectToRoute('display_pres');
    }

    //UPDATE
    /**
     * @Route("/modifPres/{id}", name="modifPres")
     */
    public function updatePres(Request $request,$id, EntityManagerInterface $entityManager): Response
    {
        $pres = $this->getDoctrine()->getManager()->getRepository(Presentation::class)->find($id);
        $form = $this->createForm(EditPresentationType::class,$pres);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('photo')->getData();
            // On boucle sur les images
            foreach($image as $ima){
                $fichier = md5(uniqid()) . '.' . $ima->guessExtension();
                $ima->move(
                    $this->getParameter('img_directory'),
                    $fichier
                );


                $entityManager = $this->getDoctrine()->getManager();
                $pres->setPhoto($fichier);
            }
            $entityManager->flush();

            return $this->redirectToRoute('display_pres');
        }
        return $this->render('presentation/updatePresentation.html.twig',['form'=>$form->createView()]);
    }
}