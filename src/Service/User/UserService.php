<?php


namespace App\Service\User;


use App\Entity\User\User;
use App\Repository\User\UserRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserService
{

    private $userRepo;

    private $tokenStorage;

    public function __construct(UserRepository $userRepo, TokenStorageInterface $tokenStorage)
    {
        $this->userRepo = $userRepo;

        $this->tokenStorage = $tokenStorage;
    }

    /**
     *
     * @return User|null
    */
    public function getCurrent(): ?User
    {

        return $this->tokenStorage->getToken()->getUser()->getId();

    }

    /**
     * @param User $user
     *
     * @return User|null
    */
    public function save(User $user): ?User
    {

        return $this->userRepo->save($user);
    }
}