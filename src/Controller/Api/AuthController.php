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
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AuthController extends AbstractController
{
    private UserRepository $userRepository;
    private EntityManagerInterface $entityManagerInterface;
    private ValidatorInterface $validatorInterface;

    /**
     * @param UserRepository $userRepository
     * @param EntityManagerInterface $entityManagerInterface
     * @param ValidatorInterface $validatorInterface
     */
    public function __construct(
        UserRepository $userRepository,
        EntityManagerInterface $entityManagerInterface,
        ValidatorInterface $validatorInterface
    )
    {
        $this->userRepository = $userRepository;
        $this->entityManagerInterface = $entityManagerInterface;
        $this->validatorInterface = $validatorInterface;
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

        $errors = $this->validatorInterface->validate($user);
        if (count($errors) > 0) {
            return new JsonResponse([
                'errors' => (string) $errors
            ], Response::HTTP_BAD_REQUEST);
        }

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
