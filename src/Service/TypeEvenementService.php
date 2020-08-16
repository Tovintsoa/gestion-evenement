<?php


namespace App\Service;

use App\Repository\TypeEvenementRepository;

class TypeEvenementService extends BaseService
{
    /**
     * @var TypeEvenementRepository
     */
    private $typeEvenement;
    function __construct(TypeEvenementRepository $typeEvenement)
    {
        $this->typeEvenement = $typeEvenement;
    }
    public function afficherParTypeEvenement($resultat,array $critereTypeEvenement){
        $result = [];
        foreach($critereTypeEvenement as $critere){
            foreach($resultat as $res){
                if(in_array($critere,$res->getTypeEvenement())){
                    array_push($result,$res);

                }
            }
        }

        $result = array_unique($result);
        return $result;

    }



}