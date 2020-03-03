<?php

namespace App\Repository;

use App\Entity\ElectionBoards;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ElectionBoards|null find($id, $lockMode = null, $lockVersion = null)
 * @method ElectionBoards|null findOneBy(array $criteria, array $orderBy = null)
 * @method ElectionBoards[]    findAll()
 * @method ElectionBoards[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ElectionBoardsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ElectionBoards::class);
    }

    // /**
    //  * @return ElectionBoards[] Returns an array of ElectionBoards objects
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


    public function findOneById($id): ?ElectionBoards
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.id = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

}
