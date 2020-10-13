<?php

namespace App\Tests\Controller\Api\Auth;

use App\Repository\UserRepository;
use App\Tests\Library\UserAuthentication;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class LoginControllerTest extends WebTestCase
{
	/**
	 * Test a successful login.
	 * 
	 * @return void
	 */
    public function testSuccessfulUserLogin()
    {
    	$client = UserAuthentication::createAuthenticatedUser('test@example.com');

        // Assert that the response status code is 200 (HTTP_OK)
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        // Assert that the "Content-Type" header is "application/json"
        $this->assertResponseHeaderSame('Content-Type', 'application/json');
    }

    /**
	 * Test a failed login.
	 * 
	 * @return void
	 */
    public function testFailedUserLogin()
    {
    	$client = UserAuthentication::createAuthenticatedUser('test-fail@example.com');

        // Assert that the response status code is 422 (HTTP_UNPROCESSABLE_ENTITY)
        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);

        // Assert that the "Content-Type" header is "application/json"
        $this->assertResponseHeaderSame('Content-Type', 'application/json');
    }
}
