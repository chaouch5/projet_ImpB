<?php

namespace App\Controller;


use App\Entity\Actualité;
use App\Form\ActualiteType;
use App\Form\EditActualiteType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class ActualiteController extends AbstractController
{
   

   
   

    /**
     * @Route("/addActualite", name="addActualite")
     */
    public function addActualiteForm(Request $request): Response
    {
        $actualite = new Actualité();
        $form = $this->createForm(ActualiteType::class, $actualite);
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
            $actualite->setPhoto($fichier);
            $em->persist($actualite);
            $em->flush();

            return $this->redirectToRoute('display_actualite');
        }
        return $this->render('actualite/addActualite.html.twig', ['form' => $form->createView()]);
    }

    //DISPLAY
    /**
     * @Route("/display_actualite", name="display_actualite")
     */
    public function displayActualite(): Response
    {
        $actualite = $this->getDoctrine()->getManager()->getRepository(Actualité::class)->findAll();
        return $this->render('actualite/index.html.twig', [
            'actualite'=>$actualite
        ]);
    }

    //delete
    /**
     * @Route("/suppActualite/{id}", name="suppActualite")
     */
    public function deleteActualite(Actualité  $actualite): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($actualite);
        $em->flush();

        return $this->redirectToRoute('display_actualite');
    }

    //UPDATE
    /**
     * @Route("/modifActualite/{id}", name="modifActualite")
     */
    public function updateActualite(Request $request,$id, EntityManagerInterface $entityManager): Response
    {
        $actualite = $this->getDoctrine()->getManager()->getRepository(Actualité::class)->find($id);
        $form = $this->createForm(EditActualiteType::class,$actualite);
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
                $actualite->setPhoto($fichier);
            }
            $entityManager->flush();

            return $this->redirectToRoute('display_actualite');
        }
        return $this->render('actualite/updateActualite.html.twig',['form'=>$form->createView()]);
    }

}