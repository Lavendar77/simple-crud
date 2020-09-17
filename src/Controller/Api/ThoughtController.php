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
     * @param Request $request
     * @param ThoughtRepository $thoughtRepository
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $thoughts = $this->thoughtRepository->findAll();

        return new JsonResponse([
        	'message' => 'Thoughts fetched successfully.',
        	'data' => [
	        	'thoughts' => $thoughts
	        ]
        ]);
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
	    	->setUser($this->userRepository->find(1)); // WIP

    	$this->entityManagerInterface->persist($thought);
    	$this->entityManagerInterface->flush();

    	return new JsonResponse([
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
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function show(Request $request, string $id)
    {
    	$thought = $this->thoughtRepository->find($id);

    	if (!$thought) {
    		return new JsonResponse([
	        	'message' => 'Resource does not exist.'
	        ], 404);
    	}

    	return new JsonResponse([
        	'message' => 'Thought fetched successfully.',
        	'data' => [
	        	'thought' => $thought
	        ]
        ]);
    }

    /**
     * Update a specified thought.
     *
     * @Route("/api/thoughts/{id}", name="api_update_thought", methods={"PUT"})
     * 
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(Request $request, string $id)
    {
    	$thought = $this->thoughtRepository->find($id);

    	if (!$thought) {
    		return new JsonResponse([
	        	'message' => 'Resource does not exist.'
	        ], 404);
    	}

    	$thought->setComment($request->get('comment'));

    	$this->entityManagerInterface->persist($thought);
    	$this->entityManagerInterface->flush();

    	return new JsonResponse([
        	'message' => 'Thought updated successfully.',
        	'data' => [
	        	'thought' => $thought
	        ]
        ]);
    }

    /**
     * Delete a specified thought.
     *
     * @Route("/api/thoughts/{id}", name="api_delete_thought", methods={"DELETE"})
     * 
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(Request $request, string $id)
    {
    	$thought = $this->thoughtRepository->find($id);

    	if (!$thought) {
    		return new JsonResponse([
	        	'message' => 'Resource does not exist.'
	        ], 404);
    	}

    	$this->entityManagerInterface->remove($thought);
		$this->entityManagerInterface->flush();

    	return new JsonResponse([
        	'message' => 'Thought deleted successfully.'
        ]);
    }
}
