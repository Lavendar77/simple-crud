<?php

namespace App\Tests\Library;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserAuthentication extends WebTestCase
{
	/**
	 * Create a client with a default Authorization header.
	 *
	 * @param string $username
	 * @param string $password
	 * @return \Symfony\Bundle\FrameworkBundle\Client
	 */
	public static function createAuthenticatedUser(string $email, string $password = 'password')
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
				'username' => $email,
	        	'password' => $password,
	        ])
	    );

	    return $client;
	}
}
