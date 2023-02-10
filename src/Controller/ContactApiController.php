<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Repository\SavRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactApiController extends AbstractController
{

    /**
     * @Route("/SAV", name="SAV_index")
     */
    public function contuct()
    {
        $contact = $this->getDoctrine()->getRepository(Contact::class)->findAll();

        return $this->render('contact_api/index.html.twig', [
            "contact" => $contact,
        ]);
    }



    /**
     * @Route("/suppContact/{id}", name="suppContact")
     */
    public function deleteContact(Contact  $contact): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($contact);
        $em->flush();

        return $this->redirectToRoute('SAV_index');
    }


    /**
     * @Route("/api/latestContact", name="get_latest_Contact", methods={"GET"})
     */
    public function getLatest(): JsonResponse
    {

        $acts = $this->getDoctrine()->getRepository(Contact::class)->findBy(array(),array('id'=>'DESC'),1,0);

        foreach ($acts as $act) {
            $data[] = [

                'email' => $act->getEmail(),

            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);

    }


    /**
     * @Route("/api/addContact", name="add_contact", methods={"POST"})
     */
    public function add(NormalizerInterface $Normalizer,Request $request,MailerInterface $mailer): JsonResponse
    {
        $data = json_decode($request->getContent(), true);


        $em = $this->getDoctrine()->getManager();
        $Post = new Contact();
        $Post->setNom($request->get('nom'));
        $Post->setEmail($request->get('email'));
        $Post->setMessage($request->get('message'));
        $Post->setMachine($request->get('machine'));
        $em->persist($Post);
        $em->flush();
        $email = (new Email())
            ->from($request->get('email'))
            ->to('abptest22@gmail.com')
            ->subject('New Message!')
            ->text('Expéditeur: '.$request->get('nom').\PHP_EOL.
                'De:    '.$request->get('email').\PHP_EOL.
                'Message:   '.$request->get('message').\PHP_EOL
            );
        $mailer->send($email);

        //  $jsonContent= $Normalizer->normalize($Post,'json',['groups'=>"produit:read"]);
        // return new Response(json_encode($jsonContent));;

        return new JsonResponse(['status' => 'reclamation created!'], Response::HTTP_CREATED);
    }

}
