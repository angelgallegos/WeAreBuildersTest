<?php

namespace App\DataFixtures;

use App\Entity\Follow\Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $statusFollow = new Status();
        $statusFollow->setCode("FOLLOW");
        $statusFollow->setName("Follow User");
        $manager->persist($statusFollow);

        $statusBlock = new Status();
        $statusBlock->setCode("BLOCK");
        $statusBlock->setName("Follower blocked");
        $manager->persist($statusBlock);

        $statusMuted = new Status();
        $statusMuted->setCode("MUTED");
        $statusMuted->setName("Follower muted");
        $manager->persist($statusMuted);

        $manager->flush();
    }
}
