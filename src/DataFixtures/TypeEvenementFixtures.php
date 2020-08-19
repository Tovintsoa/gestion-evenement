<?php

namespace App\DataFixtures;

use App\Entity\LieuEvenement;
use App\Entity\TypeEvenement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TypeEvenementFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        foreach($this->getData() as $type){
            $typeEvent = new TypeEvenement();
            $typeEvent->setType($type);
            $manager->persist($typeEvent);
            $manager->flush();
        }

    }
    public function getData(){
        return ['Couple', 'Famille', "Amis", "1er rendez-vous", "Business","Collaborateurs"];
    }
}
