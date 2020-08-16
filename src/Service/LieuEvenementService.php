<?php


namespace App\Service;


use App\Repository\EvenementRepository;
use App\Repository\TypeEvenementRepository;

class LieuEvenementService extends BaseService
{

    public function afficherParLieuEvenement($resultat,array $critere){
       $result = [];

        foreach($critere as $crit){
            foreach($resultat as $res){
                //dump($res->getLieuEvenement());
                foreach($res->getLieuEvenement() as $temp){
                    if(array_search($crit,$temp) !== false){
                         array_push($result,$res);
                    }
                }
            }
        }
        $result = array_unique($result);
        return $result;

       // dump($result); die;
    }


}