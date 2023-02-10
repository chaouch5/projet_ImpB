<?php

namespace App\Controller;

use App\Entity\Feedback;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FeedBackControllerApiController extends AbstractController
{


    /**
     * @Route("/FeedBack", name="FeedBack_index")
     */
    public function FeedBack()
    {
        $FeedBack = $this->getDoctrine()->getRepository(Feedback::class)->findAll();

        return $this->render('FeedBack/index.html.twig', [
            "FeedBack" => $FeedBack,
        ]);
    }



    /**
     * @Route("/api/addFeedback", name="add_feedback", methods={"POST"})
     */
    public function add(NormalizerInterface $Normalizer,Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);


        $em = $this->getDoctrine()->getManager();
        $Post = new Feedback();
        $Post->setNom($request->get('nom'));
        $Post->setEmail($request->get('email'));
        $Post->setFeedback($request->get('feedback'));
        $em->persist($Post);
        $em->flush();





      //  $jsonContent= $Normalizer->normalize($Post,'json',['groups'=>"produit:read"]);
       // return new Response(json_encode($jsonContent));;

        return new JsonResponse(['status' => 'feedback created!'], Response::HTTP_CREATED);
    }



    /**
     * @Route("/suppFeedback/{id}", name="suppFeedback")
     */
    public function deleteContact(Feedback  $contact): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($contact);
        $em->flush();

        return $this->redirectToRoute('FeedBack_index');
    }
}
