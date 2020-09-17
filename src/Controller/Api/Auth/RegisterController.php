<?php

namespace App\Controller\Api\Auth;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{
    private UserRepository $userRepository;
    private EntityManagerInterface $entityManagerInterface;
    private ValidatorInterface $validatorInterface;
    private UserPasswordEncoderInterface $passwordEncoder;

    /**
     * @param UserRepository $userRepository
     * @param EntityManagerInterface $entityManagerInterface
     * @param ValidatorInterface $validatorInterface
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(
        UserRepository $userRepository,
        EntityManagerInterface $entityManagerInterface,
        ValidatorInterface $validatorInterface,
        UserPasswordEncoderInterface $passwordEncoder
    )
    {
        $this->userRepository = $userRepository;
        $this->entityManagerInterface = $entityManagerInterface;
        $this->validatorInterface = $validatorInterface;
        $this->passwordEncoder = $passwordEncoder;
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
}
