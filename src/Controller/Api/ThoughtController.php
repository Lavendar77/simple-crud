<?php

namespace App\Controller\Api;

use App\Entity\Thought;
use App\Repository\ThoughtRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ThoughtController extends AbstractController
{
	private ThoughtRepository $thoughtRepository;
	private UserRepository $userRepository;
	private EntityManagerInterface $entityManagerInterface;

	/**
	 * @param ThoughtRepository $thoughtRepository
	 * @param UserRepository $userRepository
	 * @param EntityManagerInterface $entityManagerInterface
	 */
	public function __construct(
		ThoughtRepository $thoughtRepository,
		UserRepository $userRepository,
		EntityManagerInterface $entityManagerInterface
	)
	{
		$this->thoughtRepository = $thoughtRepository;
		$this->userRepository = $userRepository;
		$this->entityManagerInterface = $entityManagerInterface;
	}

    /**
     * Get all the thoughts by the user.
     * 
     * @Route("/api/thoughts", name="api_fetch_all_thoughts", methods={"GET"})
     * 
     * @return JsonResponse
     */
    public function index()
    {
        $thoughts = $this->thoughtRepository->findBy([
            'user' => $this->getUser()
        ]);

        return new JsonResponse([
            'status' => true,
        	'message' => 'Thoughts fetched successfully.',
        	'data' => [
	        	'thoughts' => $thoughts
	        ]
        ], Response::HTTP_OK);
    }

    /**
     * Store a thought.
     *
     * @Route("/api/thoughts", name="api_store_thought", methods={"POST"})
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
    	$thought = new Thought();
    	$thought
	    	->setComment($request->get('comment'))
	    	->setUser($this->getUser());

    	$this->entityManagerInterface->persist($thought);
    	$this->entityManagerInterface->flush();

    	return new JsonResponse([
            'status' => true,
        	'message' => 'Thought created successfully.',
        	'data' => [
	        	'thought' => $thought
	        ]
        ], Response::HTTP_CREATED);
    }

    /**
     * Fetch a specified thought.
     *
     * @Route("/api/thoughts/{id}", name="api_fetch_thought", methods={"GET"})
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id)
    {
    	$thought = $this->thoughtRepository->findBy([
            'user' => $this->getUser(),
            'id' => $id
        ]);

    	if (!$thought) {
    		return new JsonResponse([
                'status' => false,
	        	'message' => 'Resource does not exist.',
                'data' => null
	        ], Response::HTTP_NOT_FOUND);
    	}

    	return new JsonResponse([
            'status' => true,
        	'message' => 'Thought fetched successfully.',
        	'data' => [
	        	'thought' => $thought
	        ]
        ], Response::HTTP_OK);
    }

    /**
     * Update a specified thought.
     *
     * @Route("/api/thoughts/{id}", name="api_update_thought", methods={"PUT"})
     * 
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id)
    {
    	$thought = $this->thoughtRepository->findOneBy([
            'user' => $this->getUser(),
            'id' => $id
        ]);

    	if (!$thought) {
    		return new JsonResponse([
                'status' => false,
	        	'message' => 'Resource does not exist.',
                'data' => null
	        ], Response::HTTP_NOT_FOUND);
    	}

    	$thought->setComment($request->get('comment'));

    	$this->entityManagerInterface->persist($thought);
    	$this->entityManagerInterface->flush();

    	return new JsonResponse([
            'status' => true,
        	'message' => 'Thought updated successfully.',
        	'data' => [
	        	'thought' => $thought
	        ]
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * Delete a specified thought.
     *
     * @Route("/api/thoughts/{id}", name="api_delete_thought", methods={"DELETE"})
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id)
    {
    	$thought = $this->thoughtRepository->findOneBy([
            'user' => $this->getUser(),
            'id' => $id
        ]);

    	if (!$thought) {
    		return new JsonResponse([
                'status' => false,
	        	'message' => 'Resource does not exist.',
                'data' => null
	        ], Response::HTTP_NOT_FOUND);
    	}

    	$this->entityManagerInterface->remove($thought);
		$this->entityManagerInterface->flush();

    	return new JsonResponse([
            'status' => true,
        	'message' => 'Thought deleted successfully.',
            'data' => null
        ], Response::HTTP_NO_CONTENT);
    }
}
