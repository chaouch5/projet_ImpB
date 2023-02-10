<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SecurityControllerApiController extends AbstractController
{
    /**
     * @Route("admin/login", name="app_login_api")
     */
    public function login(Request $request)
    {
        $username = $request->query->get("username");
        $password = $request->query->get("password");

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->findOneBy(['username'=>$username]);

        if($user){
            if(password_verify($password, $user->getPassword())){

                $serializer = new Serializer([new ObjectNormalizer()]);
                $formatted = $serializer->normalize($user);
                return new JsonResponse($formatted);

            }
            else{
                return new Response("password not found");

            }
        }else{
            return new Response("User not found");
        }

    }
}
