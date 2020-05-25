<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Cart;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
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
        $cart = new Cart();
        $user->setCart($cart);
        $user->setRoles(array('ROLE_ADMIN'));
        $user->setEmail('perico_palotes@gmail.com');
        $user->setPassword(
            $this->passwordEncoder->encodePassword($user, '1234')
        );
        $manager->persist($user);
        $manager->persist($cart);
        $manager->flush();
    }
}