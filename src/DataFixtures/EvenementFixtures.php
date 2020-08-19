<?php

namespace App\DataFixtures;

use App\Entity\Evenement;
use App\Entity\EvenementLieuEvenement;
use App\Entity\LieuEvenement;
use App\Repository\UtilisateurRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EvenementFixtures extends Fixture implements DependentFixtureInterface
{
    private $utilisateurRepository;

    function __construct(UtilisateurRepository $utilisateurRepository)
    {
        $this->utilisateurRepository = $utilisateurRepository;
    }

    public function load(ObjectManager $manager)
    {
        $utilisateur = $this->utilisateurRepository->findAll();
        //dd($utilisateur);
        // $product = new Product();
        // $manager->persist($product);

        for($i = 0; $i< 10 ;$i++){
            $evenement = new Evenement();
            $evenement->setBudgetEvenement(50000);
            $evenement->setDateDebutEvenement(new \DateTime());
            $evenement->setDateFinEvenement((new \DateTime())->add(new \DateInterval('P2D')));
            $evenement->setDescriptionEvenement("Event".$i);
            $evenement->setNomEvenement("Evenement".$i);
            $evenement->setCreateurEvenementId($utilisateur[0]);
            $manager->persist($evenement);
            $manager->flush();
        }

    }
    public function getDependencies()
    {
        return array(
            UtilisateurFixtures::class,
        );
    }
}
