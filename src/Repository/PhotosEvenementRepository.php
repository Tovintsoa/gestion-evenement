<?php

namespace App\Repository;

use App\Entity\PhotosEvenement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PhotosEvenement|null find($id, $lockMode = null, $lockVersion = null)
 * @method PhotosEvenement|null findOneBy(array $criteria, array $orderBy = null)
 * @method PhotosEvenement[]    findAll()
 * @method PhotosEvenement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhotosEvenementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PhotosEvenement::class);
    }

    // /**
    //  * @return PhotosEvenement[] Returns an array of PhotosEvenement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PhotosEvenement
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
