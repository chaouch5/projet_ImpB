<?php

namespace App\Controller;

use App\Entity\Promotion;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PromotionApiController extends AbstractController
{
     /**
     * @Route("api/getPromotion", name="api_get_all_Promotion", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $pres = $this->getDoctrine()->getRepository(Promotion::class)->findAll();
        $data = [];

        foreach ($pres as $pre) {
            $data[] = [
                'id' => $pre->getId(),
                'photo' => $pre->getPhoto(),
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }
}
