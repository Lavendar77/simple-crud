<?php

namespace App\Tests\Controller\Api\Auth;

use Faker;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class RegisterControllerTest extends WebTestCase
{
	/**
	 * Test the successful registration of a user.
	 * 
	 * @return void
	 */
    public function testSuccessfulUserRegistration()
    {
    	$faker = Faker\Factory::create();

        $client = static::createClient();

        $crawler = $client->request(
        	'POST',
        	'/api/register',
        	[
	        	'first_name' => $faker->firstName,
	        	'last_name' => $faker->lastName,
	        	'email' => $faker->unique()->safeEmail,
	        	'password' => 'password',
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
	 * Test the failed registration of a user.
	 * 
	 * @return void
	 */
    public function testFailedUserRegistration()
    {
    	$faker = Faker\Factory::create();

        $client = static::createClient();

        $crawler = $client->request(
        	'POST',
        	'/api/register',
        	[
	        	'first_name' => $faker->firstName,
	        	'last_name' => $faker->lastName,
	        	'email' => 'test',
	        	'password' => 'password',
	        ],
	        [],
	        [
				'CONTENT_TYPE' => 'application/json',
			]
	    );

        // Assert that the response status code is 400 (HTTP_BAD_REQUEST)
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);

        // Assert that the "Content-Type" header is "application/json"
        $this->assertResponseHeaderSame('Content-Type', 'application/json');
    }
}
