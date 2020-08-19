<?php

namespace App\DataFixtures;

use App\Entity\LieuEvenement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LieuEvenementFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        foreach($this->getData() as $lieu){
            $lieuEvent = new LieuEvenement();
            $lieuEvent->setNomLieuEvenement($lieu);
            $manager->persist($lieuEvent);
            $manager->flush();
        }

    }
    public function getData(){
        return ['Antananarivo', 'Toamasina', "Antsiranana", "Mahajanga", "Fianarantsoa","Toliary"];
    }
}
