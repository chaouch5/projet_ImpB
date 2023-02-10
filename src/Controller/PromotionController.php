<?php

namespace App\Controller;

use App\Entity\Promotion;
use App\Form\PromotionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PromotionController extends AbstractController
{
    /**
     * @Route("/promos", name="app_promotion_index")
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $promos = $entityManager
            ->getRepository(Promotion::class)
            ->findAll();

           // $produits = $this->getDoctrine()->getRepository(Produit::class)->findAll();


        return $this->render('promotion/index.html.twig', [
            'promos' => $promos,
        ]);

    }


      /**
     * @Route("/addPromo", name="app_promo_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $promos = new Promotion();
        $form = $this->createForm(PromotionType::class, $promos);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {



            $image = $form->get('photo')->getData();
            // On boucle sur les images
            foreach($image as $ima){
                $fichier = md5(uniqid()) . '.' . $ima->guessExtension();

                $ima->move(
                    $this->getParameter('img_directory'),
                    $fichier
                );
            }
            $entityManager = $this->getDoctrine()->getManager();
            $promos->setPhoto($fichier);
            $entityManager->persist($promos);
            $entityManager->flush();

            return $this->redirectToRoute('app_promotion_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('promotion/new.html.twig', [
            'produit' => $promos,
            'form' => $form->createView(),
        ]);
    }





     /**
     * @Route("/delPromo/{id}", name="app_promo_delete")
     */
    public function delete(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $promos = $entityManager->getRepository(Promotion::class)->find($id);
        $entityManager->remove($promos);
        $entityManager->flush();

        return $this->redirectToRoute("app_promotion_index");

    }






}
