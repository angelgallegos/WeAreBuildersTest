<?php


namespace App\Service\User;


use App\Entity\User\User;
use App\Repository\User\UserRepository;

class UserService
{

    private $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    /**
     * @param int $id
     *
     * @return User|null
    */
    public function get(int $id): ?User
    {

        return $this->userRepo->find($id);

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

    /**
     * @param User $user
     * @param array $data
     *
     * @return array
    */
    public function update(User $user, array $data): array
    {
        $oldData = [
            "name" => $user->getName(),
            "last_name" => $user->getLastName(),
            "biography" => $user->getBiography(),
            "birthday" => $user->getBirthday()->format('Y-m-d'),
            "email" => $user->getEmail()
        ];

        unset($data["email"]);
        unset($data["birthday"]);

        return array_merge($oldData, $data);
    }
}