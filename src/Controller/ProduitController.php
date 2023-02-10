<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Form\EditProduitType;
use App\Form\SearchType;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


/**
 * @Route("/produit")
 */
class ProduitController extends AbstractController
{
    /**
     * @Route("/", name="app_produit_index")
     */
    public function index(EntityManagerInterface $entityManager ,Request $request ,ProductsRepository $productsRepository ): Response
    {

        $joueur = $this->getDoctrine()->getRepository(Produit::class)->findAll();

        //$C=$this->getDoctrine()->getRepository(Categorie::class)->findAll();
        $formsearchI = $this->createForm(SearchType::class);
        $formsearchI->handleRequest($request);
        if ($formsearchI->isSubmitted()) {
            $nom = $formsearchI->getData();
            $TSearch = $productsRepository->search($nom['nom']);

            return $this->render("produit/index.html.twig",
                array("produits" => $TSearch, "formsearch" => $formsearchI->createView()));
        }
        return $this->render("produit/index.html.twig", array('produits' => $joueur, "formsearch" => $formsearchI->createView()));
    }

    /**
     * @Route("/new", name="app_produit_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
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
            $produit->setPhoto($fichier);
            $entityManager->persist($produit);
            $entityManager->flush();

            return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('produit/new.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_produit_show", methods={"GET"})
     */
    public function show(Produit $produit): Response
    {
        return $this->render('produit/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="app_produit_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Produit $produit, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EditProduitType::class, $produit);
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


                $entityManager = $this->getDoctrine()->getManager();
                $produit->setPhoto($fichier);
            }
            $entityManager->flush();

            return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="app_produit_delete")
     */
    public function delete(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository(Produit::class)->find($id);
        $entityManager->remove($product);
        $entityManager->flush();

        return $this->redirectToRoute("app_produit_index");

        //return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
    }


}
