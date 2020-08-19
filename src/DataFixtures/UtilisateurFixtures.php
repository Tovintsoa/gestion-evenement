<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UtilisateurFixtures extends Fixture
{
    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
     {
         $this->passwordEncoder = $passwordEncoder;
     }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $utilisateur = new Utilisateur();
        $utilisateur->setAdresseUtilisateur("III D 20 Bis")
            ->setMailUtilisateur("tianatovintsoa@gmail.com")
            ->setLoginUtilisateur("Tovintsoa")
            ->setNomUtilisateur("Rakotoarivelo")
            ->setPrenomUtilisateur('Tovintsoa')
            ->setRoles(["ROLE_USER"])
            ->setActivationCompte(true);

        $utilisateur->setPassword($this->passwordEncoder->encodePassword($utilisateur, 'azertyuiop'));
        $manager->persist($utilisateur);

        $manager->flush();
    }
}
