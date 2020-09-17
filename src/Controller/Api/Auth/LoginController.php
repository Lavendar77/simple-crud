<?php

namespace App\Controller\Api\Auth;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    private UserRepository $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(
        UserRepository $userRepository
    )
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Sign-in to the system.
     * 
     * @Route("/api/login", name="api_login", methods={"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $user = $this->userRepository->findOneBy([
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ]);

        if (!$user) {
            return new JsonResponse([
                'email' => 'The provided credentials are incorrect.'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return new JsonResponse([
        	'message' => 'Login successful.',
        	'data' => [
                'user' => $user,
                'token' => '{{token}}'
            ]
        ]);
    }
}
