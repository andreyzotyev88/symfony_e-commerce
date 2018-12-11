<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Roles;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $roleUser = new Roles();
        $roleAdmin = new Roles();
        $roleAdmin->setName('ROLE_ADMIN');
        $roleUser->setName('ROLE_USER');
        $manager->persist($roleUser);
        $manager->persist($roleAdmin);
        $user = new User();
        $user->setUsername("Admin");
        $user->setPassword($this->passwordEncoder->encodePassword($user,'password'));
        $user->setEmail("andrey.zotyev@gmail.com");
        $user->setRoles($roleAdmin);
        $user->setFio('Андрей Зотьев Николаевич');
        $user->setPhone('89175105019');
        $manager->persist($user);
        $manager->flush();
    }
}
