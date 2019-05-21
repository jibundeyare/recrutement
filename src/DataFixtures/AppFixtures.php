<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $adminEmail;
    private $adminPassword;
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder, string $adminEmail, string $adminPassword)
    {
        $this->encoder = $encoder;
        $this->adminEmail = $adminEmail;
        $this->adminPassword = $adminPassword;
    }

    public function load(ObjectManager $manager)
    {
        // super admin
        $user = new User();
        $user->setEmail($this->adminEmail);
        $user->setRoles(['ROLE_SUPER_ADMIN']);
        $password = $this->encoder->encodePassword($user, $this->adminPassword);
        $user->setPassword($password);
        $manager->persist($user);

        // sauvegarder le tout en BDD
        $manager->flush();
    }
}
