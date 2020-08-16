<?php

namespace App\Repository;

use App\Entity\Evenement;
use App\Entity\EvenementLieuEvenement;
use App\Entity\LieuEvenement;
use App\Entity\TypeEvenement;
use App\Service\LieuEvenementService;
use App\Service\TypeEvenementService;
use Cassandra\Type;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Evenement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evenement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evenement[]    findAll()
 * @method Evenement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvenementRepository extends ServiceEntityRepository
{
    /**
     * @var TypeEvenementService
     */
    private $typeEvenementService;
    /**
     * @var LieuEvenementService
     */
    private $lieuEvenementService;
    public function __construct(TypeEvenementService $typeEvenementService,LieuEvenementService $lieuEvenementService,ManagerRegistry $registry)
    {

        parent::__construct($registry, Evenement::class);
        $this->typeEvenementService = $typeEvenementService;
        $this->lieuEvenementService = $lieuEvenementService;
    }

    // /**
    //  * @return Evenement[] Returns an array of Evenement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Evenement
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function chercherEvenement(array $critere){
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $res = $qb->select('u')
            ->from('App:Evenement','u')
            ->where("1<2");
        //dump($critere);
        dump($critere);
        //$query = "SELECT * FROM evenement e where 1<2";

        if($critere['date_evenement_debut'] !== ''){
            //$query .= " AND e.`date_debut_evenement` like '".$critere['date_evenement_debut']."'";
            $res->andWhere('u.dateDebutEvenement >= ?1');
            $res->setParameter(1,$critere['date_evenement_debut']);
        }
        if($critere['date_evenement_fin'] !== ''){
           // $query .= " AND e.`date_fin_evenement` like '".$critere['date_evenement_fin']."'" ;
            $res->andWhere('u.dateFinEvenement >= ?2');
            $res->setParameter(2,$critere['date_evenement_fin']);
        }
        if($critere['budget_evenement_min'] !== ''){
           // $query .= " AND e.`budget_evenement` >= ".$critere['budget_evenement_min'];
            $res->andWhere('u.budgetEvenement >= ?3');
            $res->setParameter(3,$critere['budget_evenement_min']);

        }
        if($critere['budget_evenement_max'] !== ''){
            //$query .= " AND e.`budget_evenement` <= ".$critere['budget_evenement_max'];
            $res->andWhere('u.budgetEvenement <= ?4');
            $res->setParameter(4,$critere['budget_evenement_max']);
        }
        $resultat = $res->getQuery()->getResult();

         if(isset($critere['type_evenement']) &&  !empty($critere['type_evenement'])){
            $resultat = $this->typeEvenementService->afficherParTypeEvenement($resultat,$critere['type_evenement']);
         }

        if(isset($critere['lieu_evenement']) && !empty($critere['lieu_evenement'])){
            $resultat = $this->lieuEvenementService->afficherParLieuEvenement($resultat,$critere['lieu_evenement']);
        }
        return $resultat;
        //echo($query); die;
        

    }
}
