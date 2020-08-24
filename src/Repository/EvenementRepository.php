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
use Doctrine\ORM\Query\ResultSetMapping;
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
    /**
     * @var LieuEvenementRepository
     */
    private $lieuEvenementRepository;
    public function __construct(TypeEvenementService $typeEvenementService,LieuEvenementService $lieuEvenementService,ManagerRegistry $registry,LieuEvenementRepository $lieuEvenementRepository)
    {

        parent::__construct($registry, Evenement::class);
        $this->typeEvenementService = $typeEvenementService;
        $this->lieuEvenementService = $lieuEvenementService;
        $this->lieuEvenementRepository = $lieuEvenementRepository;
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

        $query = "SELECT e.*,te.type,le.`nom_lieu_evenement` FROM evenement	AS e LEFT JOIN
evenement_type_evenement AS ete ON e.id = ete.evenement_id LEFT JOIN type_evenement AS te ON ete.type_evenement_id = te.`id` 
LEFT JOIN evenement_lieu_evenement AS ele ON e.id = ele.id_evenement_id LEFT JOIN lieu_evenement AS le ON ele.id_lieu_evenement_id = le.`id` where 1<2";

        if($critere['date_evenement_debut'] !== ''){
            $query .= " AND e.`date_debut_evenement` >= '".$critere['date_evenement_debut']."'";
           // $query .= " AND e.`date_debut_evenement` like (?)";

        }
        if($critere['date_evenement_fin'] !== ''){
            $query .= " AND e.`date_fin_evenement` <= '".$critere['date_evenement_fin']."'" ;
            //$query .= " AND e.`date_fin_evenement` like (?)" ;

        }
        if($critere['budget_evenement_min'] !== ''){
           $query .= " AND e.`budget_evenement` >= ? ";
        }
        if($critere['budget_evenement_max'] !== ''){
            $query .= " AND e.`budget_evenement` <=  ? ";

        }
       // $resultat = $res->getQuery()->getResult();

         if(isset($critere['type_evenement']) &&  !empty($critere['type_evenement'])){
             $query .= ' AND ete.type_evenement_id IN(';
             $m = 0;
             foreach($critere['type_evenement'] as $type){
                 $m++;
                $query .= $type;
                if($m < sizeof($critere['type_evenement'])){
                    $query .= ',';
                }

             }
             $query .= ')';

         }

        if(isset($critere['lieu_evenement']) && !empty($critere['lieu_evenement'])){
            $query .= ' AND ele.id_lieu_evenement_id IN(';
            $m = 0;
            foreach($critere['lieu_evenement'] as $lieu){
                $m++;
                $query .= $lieu;
                if($m < sizeof($critere['lieu_evenement'])){
                    $query .= ',';
                }
            }
            $query .= ')';
        }
        if(isset($critere['position_value']) &&  $critere['position_value'] !== "" ){
            $lieu = $this->lieuEvenementRepository->findOneBy(["nomLieuEvenement" => $critere['position_value']]);
            $query .= ' AND ele.id_lieu_evenement_id IN('.$lieu->getId().")";
        }
        //echo($query); die;
        $query .= ' group by e.id';
        //echo($query); die;

        $rsm = new ResultSetMappingBuilder($this->getEntityManager());
        $rsm->addEntityResult(Evenement::class, "e");
     /*   $rsm->addEntityResult(EvenementLieuEvenement::class, "ele");
        $rsm->addEntityResult(LieuEvenement::class,"le");
        $rsm->addEntityResult(TypeEvenement::class,'te');*/
        foreach ($this->getClassMetadata()->fieldMappings as $obj) {
            $rsm->addFieldResult("e", $obj["columnName"], $obj["fieldName"]);
        }
        $stmt = $this->getEntityManager()->createNativeQuery($query, $rsm);
        if(null ==! $critere) {

            if($critere['budget_evenement_min'] !== ''){
                $stmt->setParameter('1', $critere['budget_evenement_min'] );
            }
            if($critere['budget_evenement_max'] !== ''){
                $stmt->setParameter('2', $critere['budget_evenement_max']);

            }
        }
        $stmt->execute();
        $res = $stmt->getResult();
        //dd($res);

        return $res;
    }
}
