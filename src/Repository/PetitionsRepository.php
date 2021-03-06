<?php

namespace App\Repository;

use App\Entity\Petitions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Petitions|null find($id, $lockMode = null, $lockVersion = null)
 * @method Petitions|null findOneBy(array $criteria, array $orderBy = null)
 * @method Petitions[]    findAll()
 * @method Petitions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PetitionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Petitions::class);
    }

    // /**
    //  * @return Petitions[] Returns an array of Petitions objects
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

    public function findOneByUserIdAndPetitionId($users_id, $petition_id): ?Petitions
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.users_id = :user')
            ->andWhere('p.id = :id')
            ->setParameter('user', $users_id)
            ->setParameter('id', $petition_id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
