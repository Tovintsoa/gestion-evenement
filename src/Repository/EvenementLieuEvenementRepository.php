<?php

namespace App\Repository;

use App\Entity\EvenementLieuEvenement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EvenementLieuEvenement|null find($id, $lockMode = null, $lockVersion = null)
 * @method EvenementLieuEvenement|null findOneBy(array $criteria, array $orderBy = null)
 * @method EvenementLieuEvenement[]    findAll()
 * @method EvenementLieuEvenement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvenementLieuEvenementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EvenementLieuEvenement::class);
    }

    // /**
    //  * @return EvenementLieuEvenement[] Returns an array of EvenementLieuEvenement objects
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
    public function findOneBySomeField($value): ?EvenementLieuEvenement
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
