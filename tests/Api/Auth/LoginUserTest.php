<?php

namespace App\Tests\Api\Auth;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class LoginUserTest extends WebTestCase
{
	/**
	 * Create a client with a default Authorization header.
	 *
	 * @param string $username
	 * @param string $password
	 * @return \Symfony\Bundle\FrameworkBundle\Client
	 */
	protected function createAuthenticatedUser(string $username, string $password = 'password')
	{
		$client = static::createClient();

        $crawler = $client->request(
        	'POST',
        	'/api/login',
        	[],
	        [],
	        [
				'CONTENT_TYPE' => 'application/json'
			],
			json_encode([
	        	'username' => $username,
	        	'password' => $password,
	        ])
	    );

	    return $client;
	}

	/**
	 * Test a successful login.
	 * 
	 * @return void
	 */
    public function testSuccessfulUserLogin()
    {
    	$client = $this->createAuthenticatedUser('test@example.com');

        // Assert that the response status code is 200 (HTTP_OK)
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        // Assert that the "Content-Type" header is "application/json"
        $this->assertResponseHeaderSame('Content-Type', 'application/json');

        $response = $client->getResponse()->getContent();
        
        // Assert that the response contains a token
        $this->assertStringContainsString('token', $response);
    }

    /**
	 * Test a failed login.
	 * 
	 * @return void
	 */
    public function testFailedUserLogin()
    {
    	$client = $this->createAuthenticatedUser('test-fail@example.com');

        // Assert that the response status code is 422 (HTTP_UNPROCESSABLE_ENTITY)
        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);

        // Assert that the "Content-Type" header is "application/json"
        $this->assertResponseHeaderSame('Content-Type', 'application/json');

        $response = $client->getResponse()->getContent();
        
        // Assert that the response contains the errors
        $this->assertStringContainsString('errors', $response);
    }
}
