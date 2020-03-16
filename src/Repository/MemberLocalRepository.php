<?php

namespace App\Repository;

use App\Entity\MemberLocal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MemberLocal|null find($id, $lockMode = null, $lockVersion = null)
 * @method MemberLocal|null findOneBy(array $criteria, array $orderBy = null)
 * @method MemberLocal[]    findAll()
 * @method MemberLocal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MemberLocalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MemberLocal::class);
    }

    // /**
    //  * @return MemberLocal[] Returns an array of MemberLocal objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MemberLocal
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
