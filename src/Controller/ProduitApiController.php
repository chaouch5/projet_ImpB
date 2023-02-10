<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Categorie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;



class ProduitApiController extends AbstractController
{
     /**
     * @Route("/api/produit", name="get_all_prods", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $prods = $this->getDoctrine()->getRepository(Produit::class)->findAll();
        $data = [];

        foreach ($prods as $produit) {
            $data[] = [
                'id' => $produit->getId(),
                'nom' => $produit->getNom(),
                'prix' => $produit->getPrix(),
                'description' => $produit->getDescription(),
                'photo' => $produit->getPhoto(),
                'fiche' => $produit->getFiche(),
                'ref' => $produit->getRef(),

               
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }


    /**
     * @Route("/api/produit/show/{id}", name="get_all_prodsd", methods={"GET"})
     */
    public function getshow($id): JsonResponse
    {
        $prods = $this->getDoctrine()->getRepository(Produit::class)->findByid($id);
        $data = [];

        foreach ($prods as $produit) {
            $data[] = [
                'id' => $produit->getId(),
                'nom' => $produit->getNom(),
                'prix' => $produit->getPrix(),
                'description' => $produit->getDescription(),
                'photo' => $produit->getPhoto(),
                'fiche' => $produit->getFiche(),
                'ref' => $produit->getRef(),


            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/api/produit/categorie", name="get_all_prods-cat", methods={"GET"})
     */
    public function getAlll(): JsonResponse
    {
        $prods = $this->getDoctrine()->getRepository(Categorie::class)->findAll();
        $data = [];

        foreach ($prods as $produit) {
            $data[] = [
                'id' => $produit->getId(),
                'nomC' => $produit->getNomC()
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }


    /**
     * @Route("/api/produit/categorie/{categorie}", name="get_all_prods-cat-filter", methods={"GET"})
     */
    public function getAllt($categorie): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $prods = $em->getRepository(Produit::class)->findByCategorie($categorie);
        $data = [];

        foreach ($prods as $produit) {
            $data[] = [
                'id' => $produit->getId(),
                'nom' => $produit->getNom(),
                'prix' => $produit->getPrix(),
                'description' => $produit->getDescription(),
                'photo' => $produit->getPhoto(),
                'fiche' => $produit->getFiche(),
                'ref' => $produit->getRef(),
                'categorie'=>$produit->__toString(),

            ];}

        return new JsonResponse($data);

    }

    /**
     * @Route("/api/add/produit", name="add_prods", methods={"POST"})
     */
    public function add(NormalizerInterface $Normalizer,Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);


        $em = $this->getDoctrine()->getManager();
        $Post = new Produit();
        $Post->setNom($request->get('nom'));
        $Post->setPrix($request->get('prix'));
        $Post->setDescription($request->get('description'));
        $Post->setPhoto($request->get('photo'));
        $Post->setFiche($request->get('fiche'));
        $Post->setRef($request->get('ref'));

       
       
        $em->persist($Post);
        $em->flush();





        $jsonContent= $Normalizer->normalize($Post,'json',['groups'=>"produit:read"]);
       // return new Response(json_encode($jsonContent));;

        return new JsonResponse(['status' => 'produit created!'], Response::HTTP_CREATED);
    }






    /**
     * @Route("api/produit/edit/{id}", name="api_prods" ,  methods={"POST"})
     */
    public function edit($id,Request $request):JsonResponse
    {

        $entityManager = $this->getDoctrine()->getManager();
        $project = $entityManager->getRepository(Produit::class)->find($id);
 
        if (!$project) {
            return $this->json('No products found for id' . $id, 404);
        }
 
        $project->setNom($request->request->get('nom'));
        $project->setPrix($request->request->get('prix'));
        $project->setDescription($request->request->get('description'));
        $project->setPhoto($request->request->get('photo'));
        $project->setFiche($request->request->get('fiche'));
        $project->setRef($request->request->get('ref'));
        $entityManager->flush();
 
        $data =  [
            'id' => $project->getId(),
            'name' => $project->getNom(),
            'prix' => $project->getPrix(),
            'description' => $project->getDescription(),
            'photo' => $project->getPhoto(),
            'fiche' => $project->getFiche(),
            'ref' => $project->getRef(),
           
        ];
         
        return $this->json($data);
    }









    /**
     * @Route("/api/produit/delete/{id}", name="delete_prods", methods={"DELETE"})
     */
    public function delete($id): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();

        $produit = $entityManager->getRepository(Produit::class)->find($id);

        $entityManager->remove($produit);
        $entityManager->flush();

        return new JsonResponse(['status' => 'produit deleted'], Response::HTTP_NO_CONTENT);
    }



      /**
     * @Route("/api/latestProd", name="get_latest_prods", methods={"GET"})
     */
    public function getLatest(): JsonResponse
    {

        
    //$prods = $repository->findBy(array(),array('id'=>'DESC'),1,0);

    $prods = $this->getDoctrine()->getRepository(Produit::class)->findBy(array(),array('id'=>'DESC'),3,0);

    foreach ($prods as $produit) {
        $data[] = [
            'id' => $produit->getId(),
            'nom' => $produit->getNom(),
            'prix' => $produit->getPrix(),
            'description' => $produit->getDescription(),
            'photo' => $produit->getPhoto(),
            'fiche' => $produit->getFiche(),
            'ref' => $produit->getRef(),
           
        ];
    }

    return new JsonResponse($data, Response::HTTP_OK);

    }

}