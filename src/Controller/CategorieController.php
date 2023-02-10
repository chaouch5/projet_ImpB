<?php

namespace App\Controller;


use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Form\EditCategorieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;





class CategorieController extends AbstractController
{



/**
 * @Route("/categories", name="cats")
 */
public function products()
{
    $cats = $this->getDoctrine()->getRepository(Categorie::class)->findAll();

    return $this->render('categorie/index.html.twig', [
        "cats" => $cats,
    ]);
}



   /**
     * @Route("/addCat", name="addCat")
     */
    public function addLivreur(Request $request): Response
    {
        $cat = new Categorie();

        $form = $this->createForm(CategorieType::class,$cat);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cat);//Add
            $em->flush();

            return $this->redirectToRoute('cats');
        }
        return $this->render('categorie/new.html.twig',
            ['form'=>$form->createView()]);

    }



/**
 * @Route("/delete-cat/{id}", name="delete_categorie")
 */
public function deleteCat(int $id): Response
{
    $entityManager = $this->getDoctrine()->getManager();
    $product = $entityManager->getRepository(Categorie::class)->find($id);
    $entityManager->remove($product);
    $entityManager->flush();

    return $this->redirectToRoute("cats");
}




  /**
     * @Route("/categorie/edit/{id}", name="app_edit_cat", methods={"GET", "POST"})
     */
    public function edit(Request $request, Categorie $categorie, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EditCategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->flush();

            return $this->redirectToRoute('cats', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('categorie/edit.html.twig', [
            'categorie' => $categorie,
            'form' => $form->createView(),
        ]);
    }
    


}







