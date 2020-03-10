<?php

namespace App\Repository;

use App\Entity\PetitionSignatures;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PetitionSignatures|null find($id, $lockMode = null, $lockVersion = null)
 * @method PetitionSignatures|null findOneBy(array $criteria, array $orderBy = null)
 * @method PetitionSignatures[]    findAll()
 * @method PetitionSignatures[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PetitionSignaturesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PetitionSignatures::class);
    }

    // /**
    //  * @return PetitionSignatures[] Returns an array of PetitionSignatures objects
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
    public function findOneBySomeField($value): ?PetitionSignatures
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
