<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;

class UserFixtures extends Fixture
{
    /**
     * @throws \Exception
     */

    private UserPasswordHasherInterface $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i < 10; $i++ ){
            $user = new User();
            $user->setEmail('victor'. $i .'@aono.fr');
            $user->setApiKey(random_int(100000000, 999999999));
            $user->setPassword($this->encoder->hashPassword($user, 'test'));
            $user->setRoles(['ROLE_USER']);


            $manager->persist($user);
        }

        $manager->flush();
    }
}
