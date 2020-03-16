<?php

namespace App\Repository;

use App\Entity\PetitionAdministration;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PetitionAdministration|null find($id, $lockMode = null, $lockVersion = null)
 * @method PetitionAdministration|null findOneBy(array $criteria, array $orderBy = null)
 * @method PetitionAdministration[]    findAll()
 * @method PetitionAdministration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PetitionAdministrationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PetitionAdministration::class);
    }

    // /**
    //  * @return PetitionAdministration[] Returns an array of PetitionAdministration objects
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
    public function findOneBySomeField($value): ?PetitionAdministration
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
