<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends Fixture
{
	private $passwordEncoder;

	/**
	 * @return void
	 */
	public function __construct(UserPasswordEncoderInterface $passwordEncoder)
	{
		$this->passwordEncoder = $passwordEncoder;
	}

	/**
	 * Load the fixtures.
	 * 
	 * @param ObjectManager $manager
	 * @return void
	 */
    public function load(ObjectManager $manager)
    {
    	$faker = Faker\Factory::create();

        $user = new User();
        $user->setFirstName($faker->firstName);
        $user->setLastName($faker->lastName);
        $user->setEmail('test@example.com');
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'password'));
        
        $manager->persist($user);
        $manager->flush();
    }
}
