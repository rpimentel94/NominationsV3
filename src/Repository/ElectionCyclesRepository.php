<?php

namespace App\Repository;

use App\Entity\ElectionCycles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ElectionCycles|null find($id, $lockMode = null, $lockVersion = null)
 * @method ElectionCycles|null findOneBy(array $criteria, array $orderBy = null)
 * @method ElectionCycles[]    findAll()
 * @method ElectionCycles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ElectionCyclesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ElectionCycles::class);
    }

    // /**
    //  * @return ElectionCycles[] Returns an array of ElectionCycles objects
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
    public function findOneBySomeField($value): ?ElectionCycles
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
