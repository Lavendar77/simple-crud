<?php

namespace App\Tests\Controller\Api;

use App\Repository\ThoughtRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Tests\Library\UserAuthentication;

class ThoughtControllerTest extends WebTestCase
{
	/**
     * Test access to authenticated user's thoughts.
     * 
     * @return void
     */
    public function testSuccessfulFetchAllUserThoughts()
    {
        $client = UserAuthentication::createAuthenticatedUser($_ENV['TEST_USER_EMAIL'], $_ENV['TEST_USER_PASSWORD']);
        $data = json_decode($client->getResponse()->getContent());

       	$client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data->token));
        $crawler = $client->request(
        	'GET',
        	'/api/thoughts',
        	[],
        	[],
        	[
        		'CONTENT_TYPE' => 'application/json',
        	]
        );

        // Assert that the response status code is 200 (HTTP_OK)
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        // Assert that the "Content-Type" header is "application/json"
        $this->assertResponseHeaderSame('Content-Type', 'application/json');
    }

    /**
     * Test storing thoughts.
     * 
     * @return void
     */
    public function testSuccessfulStoreUserThought()
    {
        $client = UserAuthentication::createAuthenticatedUser($_ENV['TEST_USER_EMAIL'], $_ENV['TEST_USER_PASSWORD']);
        $data = json_decode($client->getResponse()->getContent());

       	$client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data->token));
        $crawler = $client->request(
        	'POST',
        	'/api/thoughts',
        	[
        		'comment' => 'This is testing! I am glad.'
        	],
        	[],
        	[
        		'CONTENT_TYPE' => 'application/json',
        	]
        );

        // Assert that the response status code is 201 (HTTP_CREATED)
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);

        // Assert that the "Content-Type" header is "application/json"
        $this->assertResponseHeaderSame('Content-Type', 'application/json');
    }

    /**
     * Test fetching a specified thought.
     * 
     * @return void
     */
    public function testSuccessfulFetchUserThought()
    {
        $client = UserAuthentication::createAuthenticatedUser($_ENV['TEST_USER_EMAIL'], $_ENV['TEST_USER_PASSWORD']);
        $data = json_decode($client->getResponse()->getContent());
       	$client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data->token));

       	// Get one thought by the user
       	$thoughtRepository = static::$container->get(ThoughtRepository::class);
       	$userRepository = static::$container->get(UserRepository::class);

       	$thought = $thoughtRepository->findOneByUser(
       		$userRepository->findOneByEmail('test@example.com')
       	);
        $id = $thought->getId();

        $crawler = $client->request(
        	'GET',
        	"/api/thoughts/{$id}",
        	[],
        	[],
        	[
        		'CONTENT_TYPE' => 'application/json',
        	]
        );

        // Assert that the response status code is 200 (HTTP_OK)
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        // Assert that the "Content-Type" header is "application/json"
        $this->assertResponseHeaderSame('Content-Type', 'application/json');
    }

    /**
     * Test updating a specified thought.
     * 
     * @return void
     */
    public function testSuccessfulUpdateUserThought()
    {
        $client = UserAuthentication::createAuthenticatedUser($_ENV['TEST_USER_EMAIL'], $_ENV['TEST_USER_PASSWORD']);
        $data = json_decode($client->getResponse()->getContent());
       	$client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data->token));

       	// Get one thought by the user
       	$thoughtRepository = static::$container->get(ThoughtRepository::class);
       	$userRepository = static::$container->get(UserRepository::class);

       	$thought = $thoughtRepository->findOneByUser(
       		$userRepository->findOneByEmail('test@example.com')
       	);
        $id = $thought->getId();

        $crawler = $client->request(
        	'PUT',
        	"/api/thoughts/{$id}",
        	[
        		'comment' => 'This is updating the current comment.'
        	],
        	[],
        	[
        		'CONTENT_TYPE' => 'application/json',
        	]
        );

        // Assert that the response status code is 202 (HTTP_ACCEPTED)
        $this->assertResponseStatusCodeSame(Response::HTTP_ACCEPTED);

        // Assert that the "Content-Type" header is "application/json"
        $this->assertResponseHeaderSame('Content-Type', 'application/json');
    }

    /**
     * Test deleting a specified thought.
     * 
     * @return void
     */
    public function testSuccessfulDestroyUserThought()
    {
        $client = UserAuthentication::createAuthenticatedUser($_ENV['TEST_USER_EMAIL'], $_ENV['TEST_USER_PASSWORD']);
        $data = json_decode($client->getResponse()->getContent());
       	$client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data->token));

       	// Get one thought by the user
       	$thoughtRepository = static::$container->get(ThoughtRepository::class);
       	$userRepository = static::$container->get(UserRepository::class);

       	$thought = $thoughtRepository->findOneByUser(
       		$userRepository->findOneByEmail('test@example.com')
       	);
        $id = $thought->getId();

        $crawler = $client->request(
        	'DELETE',
        	"/api/thoughts/{$id}",
        	[],
        	[],
        	[
        		'CONTENT_TYPE' => 'application/json',
        	]
        );

        // Assert that the response status code is 204 (HTTP_NO_CONTENT)
        $this->assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);
    }
}
