<?php

namespace App\Repository;

use App\Entity\ElectionBoardPositions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ElectionBoardPositions|null find($id, $lockMode = null, $lockVersion = null)
 * @method ElectionBoardPositions|null findOneBy(array $criteria, array $orderBy = null)
 * @method ElectionBoardPositions[]    findAll()
 * @method ElectionBoardPositions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ElectionBoardPositionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ElectionBoardPositions::class);
    }

    // /**
    //  * @return ElectionBoardPositions[] Returns an array of ElectionBoardPositions objects
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
    public function findOneBySomeField($value): ?ElectionBoardPositions
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
