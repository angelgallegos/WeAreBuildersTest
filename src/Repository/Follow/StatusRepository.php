<?php


namespace App\Repository\Follow;


use App\Entity\Follow\Status;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class StatusRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry, Status::class);
    }

    public function save(Status $status): ?Status
    {
        $em = $this->getEntityManager();
        $em->persist($status);
        $em->flush();

        return $status;
    }


}