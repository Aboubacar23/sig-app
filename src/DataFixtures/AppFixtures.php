<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Client;
use App\Entity\Fournisseur;
use App\Entity\Entrepot;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
     private $password;
     public function __construct(UserPasswordHasherInterface $passwordEncoder)
     {
         $this->password = $passwordEncoder;
     }

    public function load(ObjectManager $manager): void
    {
         $user = new User();
         $user->SetUsername("admin");
         $password = $this->password->hashPassword($user, 'admin');
         $user->SetPassword($password); 
         $user->SetEmail("admin@gmail.com");
         $user->SetNom('Admin');
         $user->SetPrenom('Mamaday');
         $user->setRoles(array('ROLE_SUPER_ADMIN'));
         $user->SetPays('Guinée');
         $user->SetVille('Conakry');
         $manager->persist($user);


         $user = new User();
         $user->SetUsername("conde224");
         $password = $this->password->hashPassword($user, 'conde224');
         $user->SetPassword($password); 
         $user->SetEmail("conde@gmail.com");
         $user->SetNom('Conde');
         $user->SetPrenom('Aboubacar Sidiki');
         $user->SetRoles(array('ROLE_SUPER_ADMIN'));
         $user->SetPays('Guinée');
         $user->SetVille('Conakry');
         $manager->persist($user);

         $manager->flush();
    }
}
