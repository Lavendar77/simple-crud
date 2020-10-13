<?php

namespace App\Controller\Api\Auth;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegisterController extends AbstractController
{
    private UserRepository $userRepository;
    private EntityManagerInterface $entityManagerInterface;
    private ValidatorInterface $validatorInterface;
    private UserPasswordEncoderInterface $passwordEncoder;
    private JWTTokenManagerInterface $JWTManager;

    /**
     * @param UserRepository $userRepository
     * @param EntityManagerInterface $entityManagerInterface
     * @param ValidatorInterface $validatorInterface
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param JWTTokenManagerInterface $JWTManager
     */
    public function __construct(
        UserRepository $userRepository,
        EntityManagerInterface $entityManagerInterface,
        ValidatorInterface $validatorInterface,
        UserPasswordEncoderInterface $passwordEncoder,
        JWTTokenManagerInterface $JWTManager
    )
    {
        $this->userRepository = $userRepository;
        $this->entityManagerInterface = $entityManagerInterface;
        $this->validatorInterface = $validatorInterface;
        $this->passwordEncoder = $passwordEncoder;
        $this->JWTManager = $JWTManager;
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
        $user->setFirstName($request->get('first_name'));
        $user->setLastName($request->get('last_name'));
        $user->setEmail($request->get('email'));
        $user->setPassword($this->passwordEncoder->encodePassword($user, $request->get('password')));

        $errors = $this->validatorInterface->validate($user);
        if (count($errors) > 0) {
            return new JsonResponse([
                'status' => false,
                'message' => 'Validation Errors',
                'data' => [
                    'errors' => (string) $errors
                ]
            ], Response::HTTP_BAD_REQUEST);
        }

        $this->entityManagerInterface->persist($user);
        $this->entityManagerInterface->flush();

        $token = $this->JWTManager->create($user);

        return new JsonResponse([
            'status' => true,
        	'message' => 'Registration successful.',
        	'data' => [
                'user' => $user,
                'token' => $token
            ]
        ], Response::HTTP_CREATED);
    }
}
