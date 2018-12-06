<?php

namespace App\DataFixtures;

use App\Entity\User;
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
        $user = new User();
        $user->setUsername("Admin");
        $user->setPassword($this->passwordEncoder->encodePassword($user,'password'));
        $user->setEmail("andrey.zotyev@gmail.com");
        $user->setFio('Андрей Зотьев Николаевич');
        $user->setPhone('89175105019');
        $manager->persist($user);
        $manager->flush();
    }
}
