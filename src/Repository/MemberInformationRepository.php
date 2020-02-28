<?php

namespace App\Repository;

use App\Entity\MemberInformation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MemberInformation|null find($id, $lockMode = null, $lockVersion = null)
 * @method MemberInformation|null findOneBy(array $criteria, array $orderBy = null)
 * @method MemberInformation[]    findAll()
 * @method MemberInformation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MemberInformationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MemberInformation::class);
    }

    // /**
    //  * @return MemberInformation[] Returns an array of MemberInformation objects
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
    public function findOneBySomeField($value): ?MemberInformation
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
