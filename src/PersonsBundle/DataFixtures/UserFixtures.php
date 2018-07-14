<?php

namespace TheFox\PersonsBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use TheFox\UserBundle\Entity\User;

final class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Admin User
        $admin = new User();
        $admin->setUsername('admin');
        $admin->setEmail('admin@localhost');
        $admin->setPlainPassword('testtest');
        $admin->addRole('ROLE_SUPER_ADMIN');
        $admin->setEnabled(true);

        $manager->persist($admin);
        $manager->flush();
    }
}
