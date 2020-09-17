<?php

namespace App\Controller\Api\Auth;

use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class LoginController extends AbstractController
{
    private UserRepository $userRepository;
    private UserPasswordEncoderInterface $encoder;
    private JWTTokenManagerInterface $JWTManager;

    /**
     * @param UserRepository $userRepository
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param JWTTokenManagerInterface $JWTManager
     */
    public function __construct(
        UserRepository $userRepository,
        UserPasswordEncoderInterface $passwordEncoder,
        JWTTokenManagerInterface $JWTManager
    )
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
        $this->JWTManager = $JWTManager;
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
            'email' => $request->get('email')
        ]);

        if (!$user || !$this->passwordEncoder->isPasswordValid($user, $request->get('password'))) {
            return new JsonResponse([
                'email' => 'The provided credentials are incorrect.'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $token = $this->JWTManager->create($user);

        return new JsonResponse([
        	'message' => 'Login was successful.',
        	'data' => [
                'user' => $user,
                'token' => $token
            ]
        ]);
    }
}
