<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    private UserRepository $userRepository;
    private EntityManagerInterface $entityManagerInterface;

    /**
     * @param UserRepository $userRepository
     * @param EntityManagerInterface $entityManagerInterface
     */
    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManagerInterface)
    {
        $this->userRepository = $userRepository;
        $this->entityManagerInterface = $entityManagerInterface;
    }

    /**
     * Create an account.
     * 
     * @Route("/api/register", name="api_register", methods={"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        $user = new User();
        $user
            ->setFirstName($request->get('first_name'))
            ->setLastName($request->get('last_name'))
            ->setUsername($request->get('username'))
            ->setPassword($request->get('password')) // WIP: Encrypt password
        ;

        $this->entityManagerInterface->persist($user);
        $this->entityManagerInterface->flush();

        return new JsonResponse([
        	'message' => 'Registration successful.',
        	'token' => '{{token}}'
        ]);
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
            'username' => $request->get('username'),
            'password' => $request->get('password')
        ]);

        if (!$user) {
            return new JsonResponse([
                'username' => 'The provided credentials are incorrect.'
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
