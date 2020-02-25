<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Member;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
      for ($i = 0; $i < 10; $i++) {
          $member = new Member();
          $member->setFirstName("Bob" . $i);
          $member->setLastName("Barker" . $i);
          $member->setFullName("Bob Barker" . $i);
          $member->setUsername("member_active" . $i);
          $member->setSagAftraId(10000008 + $i);
          $member->setSigningRoute("DUE83SW" . $i);
          $member->setAdministrationCode("WWJ83JAV93" . $i);
          $member->setAccessKey("FHW9834ZHWDK2274DJWE743JQW" . $i);
          $member->setGoodStanding(1);
          $member->setActive(1);
          $member->setDateCreated(1243228593 + $i);
          $member->setElectionCycleId(1);
          $manager->persist($member);
      }

        $manager->flush();
    }
}
