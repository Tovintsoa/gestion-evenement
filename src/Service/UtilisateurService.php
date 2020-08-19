<?php


namespace App\Service;

use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;

class UtilisateurService extends BaseService
{
    /**
     * @var UtilisateurRepository
     */
    private $utilisateurRepository;
    function __construct(UtilisateurRepository $utilisateurRepository)
    {
        $this->utilisateurRepository = $utilisateurRepository;
    }



}