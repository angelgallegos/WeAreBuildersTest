<?php


namespace App\Service\Follow;


use App\Repository\Follow\StatusRepository;

class StatusService
{
    private $statusRepo;

    public function __construct(StatusRepository $statusRepo)
    {
        $this->statusRepo = $statusRepo;
    }

}