<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    /**
     * Get authenticated user.
     * 
     * @Route("/api/user", name="api_user", methods={"GET"})
     *
     * @return JsonResponse
     */
    public function index()
    {
        return new JsonResponse([
            'user' => $this->getUser()
        ]);
    }
}
