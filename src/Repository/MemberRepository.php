<?php

namespace App\Repository;

use App\Entity\Member;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Member|null find($id, $lockMode = null, $lockVersion = null)
 * @method Member|null findOneBy(array $criteria, array $orderBy = null)
 * @method Member[]    findAll()
 * @method Member[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MemberRepository extends ServiceEntityRepository
{
    private $manager;

    public function __construct( ManagerRegistry $registry, EntityManagerInterface $manager )
    {
        parent::__construct($registry, Member::class);
        $this->manager = $manager;
    }

    /*private function saveMember($first_name, $last_name, $full_name, $sag_aftra_id, $signing_route, $username, $administration_code, $access_key, $date_created, $good_standing, $election_cycle_id, $active)
    {
        $newMember = new Member();

        $newMember
            ->setFirstName($first_name);
            ->setLastName($last_name);
            ->setFullName($full_name);
            ->setSagAftraId($sag_aftra_id);
            ->setSigningRoute($signing_route);
            ->setUsername($username);
            ->setAdministrationCode($administration_code);
            ->setAccessKey($access_key);
            ->setDateCreated($date_created);
            ->setGoodStanding($good_standing);
            ->setElectionCycleId($election_cycle_id);
            ->setActive($active);

        $this->manager->persist($newMember);
        $this->manager->flush();
    }

    // /**
    //  * @return Member[] Returns an array of Member objects
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

    public function findOneByMemberAccessKey($access_key): ?Member
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.access_key = :val')
            ->andWhere('m.active = :num')
            ->setParameter('val', $access_key)
            ->setParameter('num', 1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findOneByUserId($id): ?Member
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.id = :val')
            ->andWhere('m.active = :num')
            ->setParameter('val', $id)
            ->setParameter('num', 1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
