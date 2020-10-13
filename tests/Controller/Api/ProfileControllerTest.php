<?php

namespace App\Tests\Controller\Api;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use App\Tests\Library\UserAuthentication;

class ProfileControllerTest extends WebTestCase
{
	/**
     * Test an authenticated access to a user profile.
     * 
     * @return void
     */
    public function testSuccessfulAccessToProfile()
    {
        $client = UserAuthentication::createAuthenticatedUser('test@example.com', 'password');
        $data = json_decode($client->getResponse()->getContent());

       	$client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data->token));

        $crawler = $client->request(
        	'GET',
        	'/api/user',
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
     * Test a unauthenticated access to a user profile.
     * 
     * @return void
     */
    public function testFailedAccessToProfile()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/api/user');

        // Assert that the response status code is 401 (HTTP_UNAUTHORIZED)
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        // Assert that the "Content-Type" header is "application/json"
        $this->assertResponseHeaderSame('Content-Type', 'application/json');
    }
}
