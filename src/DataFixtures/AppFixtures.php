<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHashInterface;

    public function __construct(UserPasswordHasherInterface $passwordHashInterface)
    {
        $this->passwordHashInterface = $passwordHashInterface;
    }

    // ...
    public function load(ObjectManager $manager)
    {
        $user = new Users();
        $user->setUsername('test');
        $user->setEmail('test@gmail.com');
        $user->setStatus(1);

        $manager->persist($user);
        $manager->flush();
    }
}
