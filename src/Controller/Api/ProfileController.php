<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
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
        $user = $this->getUser();

        return new JsonResponse([
            'status' => true,
            'message' => 'Profile fetched successfully.',
            'data' => [
                'user' => $user
            ]
        ], Response::HTTP_OK);
    }
}
