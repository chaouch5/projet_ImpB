<?php

namespace App\Controller;

use App\Entity\Actualité;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use App\Entity\Presentation;

class PresentationApiController extends AbstractController
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

    /**
     * @Route("api/getPresentation", name="api_get_all_Presentation", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $pres = $this->getDoctrine()->getRepository(Presentation::class)->findAll();
        $data = [];

        foreach ($pres as $pre) {
            $data[] = [
                'id' => $pre->getId(),
                'titre' => $pre->getTitre(),
                'text' => $pre->getText(),
                'photo' => $pre->getPhoto(),
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/api/add/presentation", name="add_presentation", methods={"POST"})
     */
    public function addPresentation(NormalizerInterface $Normalizer,Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);


        $em = $this->getDoctrine()->getManager();
        $Post = new Presentation();
        $Post->setTitre($request->get('titre'));
        $Post->setText($request->get('text'));
        $Post->setPhoto($request->get('photo'));

        $em->persist($Post);
        $em->flush();

        $jsonContent= $Normalizer->normalize($Post,'json',['groups'=>"produit:read"]);


        return new JsonResponse(['status' => 'presentation created!'], Response::HTTP_CREATED);
    }

    /**
     * @Route("api/presentation/edit/{id}", name="api_presentation" ,  methods={"POST"})
     */
    public function edit($id,Request $request):JsonResponse
    {

        $entityManager = $this->getDoctrine()->getManager();
        $project = $entityManager->getRepository(Presentation::class)->find($id);

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
     * @Route("/api/presentation/delete/{id}", name="delete_presentation", methods={"DELETE"})
     */
    public function delete($id): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();

        $actualite = $entityManager->getRepository(Presentation::class)->find($id);

        $entityManager->remove($actualite);
        $entityManager->flush();

        return new JsonResponse(['status' => 'presentation deleted'], Response::HTTP_NO_CONTENT);
    }
}