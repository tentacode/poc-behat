<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $admin = new User();
        $admin->setName('Tentacode');
        $admin->setToken('t3nt4c0d3');
        $admin->setEmail('tentacode@example.com');
        $admin->setROLE('ROLE_ADMIN');
        $manager->persist($admin);
        
        $user = new User();
        $user->setName('John Doe');
        $user->setToken('j0hnd03');
        $user->setEmail('john.doe@example.com');
        $user->setROLE('ROLE_USER');
        $manager->persist($user);
        
        $user = new User();
        $user->setName('Jane Doe');
        $user->setToken('j4n3d03');
        $user->setEmail('jane.doe@example.com');
        $user->setROLE('ROLE_USER');
        $manager->persist($user);

        $manager->flush();
    }
}
