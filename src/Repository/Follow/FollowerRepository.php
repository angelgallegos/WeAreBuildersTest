<?php


namespace App\Repository\Follow;

use App\Entity\Follow\Follower;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class FollowerRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry, Follower::class);
    }

    public function save(Follower $follower): ?Follower
    {
        $em = $this->getEntityManager();
        $em->persist($follower);
        $em->flush();

        return $follower;
    }


}