<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Actualité;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;


class ActualiteApiController extends AbstractController
{
  
    /**
     * @Route("api/getActualite", name="api_get_all_actualite", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $actualites = $this->getDoctrine()->getRepository(Actualité::class)->findAll();
        $data = [];

        foreach ($actualites as $actualite) {
            $data[] = [
                'id' => $actualite->getId(),
                'titre' => $actualite->getTitre(),
                'text' => $actualite->getText(),
                'photo' => $actualite->getPhoto(),
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/api/add/actualite", name="add_actualite", methods={"POST"})
     */
    public function addActualite(NormalizerInterface $Normalizer,Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);


        $em = $this->getDoctrine()->getManager();
        $Post = new Actualité();
        $Post->setTitre($request->get('titre'));
        $Post->setText($request->get('text'));
        $Post->setPhoto($request->get('photo'));

        $em->persist($Post);
        $em->flush();

        $jsonContent= $Normalizer->normalize($Post,'json',['groups'=>"produit:read"]);


        return new JsonResponse(['status' => 'Actualite created!'], Response::HTTP_CREATED);
    }


    /**
     * @Route("/api/actualite/delete/{id}", name="delete_actualite", methods={"DELETE"})
     */
    public function delete($id): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();

        $actualite = $entityManager->getRepository(Actualité::class)->find($id);

        $entityManager->remove($actualite);
        $entityManager->flush();

        return new JsonResponse(['status' => 'actualite deleted'], Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("api/actualite/edit/{id}", name="api_actualite" ,  methods={"POST"})
     */
    public function edit($id,Request $request):JsonResponse
    {

        $entityManager = $this->getDoctrine()->getManager();
        $project = $entityManager->getRepository(Actualité::class)->find($id);

        if (!$project) {
            return $this->json('No project found for id' . $id, 404);
        }

        $project->setTitre($request->request->get('titre'));
        $project->setText($request->request->get('text'));
        $project->setPhoto($request->request->get('photo'));
        $entityManager->flush();

        $data =  [
            'id' => $project->getId(),
            'titre' => $project->getTitre(),
            'text' => $project->getText(),
            'photo' => $project->getPhoto(),
        ];

        return $this->json($data);
    }





          /**
     * @Route("/api/latestAct", name="get_latest_act", methods={"GET"})
     */
    public function getLatest(): JsonResponse
    {

    $acts = $this->getDoctrine()->getRepository(Actualité::class)->findBy(array(),array('id'=>'DESC'),1,0);

    foreach ($acts as $act) {
        $data[] = [
            'id' => $act->getId(),
            'titre' => $act->getTitre(),
            'text' => $act->getText(),
            'photo' => $act->getPhoto(),
           
        ];
    }

    return new JsonResponse($data, Response::HTTP_OK);

    }

}
