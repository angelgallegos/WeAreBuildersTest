<?php


namespace App\Service\Follow;


use App\Entity\Follow\Follower;
use App\Repository\Follow\FollowerRepository;
use App\Repository\Follow\StatusRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class FollowerService
{
    private $followerRepo;

    private $statusRepo;

    private $tokenStorage;

    public function __construct(FollowerRepository $followerRepo,
                                StatusRepository $statusRepo,
                                TokenStorageInterface $tokenStorage)
    {
        $this->followerRepo = $followerRepo;
        $this->statusRepo = $statusRepo;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @param Follower $follower
     *
     * @return Follower|null
     */
    public function save(Follower $follower): ?Follower
    {

        return $this->followerRepo->save($follower);
    }

    /**
     * @param int $id
     *
     * @return Follower|null
     */
    public function get(int $id): ?Follower
    {

        return $this->followerRepo->find($id);
    }

    /**
     * Finds a follower using the user two passed and the current user
     *
     * @param int $userId
     *
     * @return Follower|null
    */
    public function findFollowing(int $userId): ?Follower
    {
        return $this->findByUsersIds(
            $this->tokenStorage->getToken()->getUser()->getId(),
            $userId);
    }

    /**
     * Finds a follower using the user two passed and the current user
     *
     * @param int $userId
     *
     * @return Follower|null
     */
    public function findFollower(int $userId): ?Follower
    {
        return $this->findByUsersIds(
            $userId,
            $this->tokenStorage->getToken()->getUser()->getId());
    }

    /**
     * @param int $userId
     *
     * @return array
     */
    public function relations(int $userId): array
    {
        $relations = [];

        $follows = $this->findFollower($userId);
        $following = $this->findFollowing($userId);

        if(!is_null($follows)){
            $relations["follows"] = $follows;
        }

        if(!is_null($following)){
            $relations["following"] = $following;
        }

        return $relations;
    }

    /**
     * @param int $userOneId
     * @param int $userTwoId
     *
     * @return Follower|object|null
    */
    public function findByUsersIds(int $userOneId, int $userTwoId): ?Follower
    {

        return $this->followerRepo->findOneBy([
            "userOne" => $userOneId,
            "userTwo" => $userTwoId
        ]);
    }

    /**
     * Fills the data for the follow form
     *
     * @param array $data
     *
     * @return array
     */
    public function follow(array $data): array
    {
        $followStatus = $this->statusRepo->findOneBy([
            "code" => "FOLLOW"
        ]);

        return array_merge($data, [
            "user_one" => $this->tokenStorage->getToken()->getUser()->getId(),
            "status" => $followStatus->getId()]);
    }

    /**
     *
     * @param Follower $follower
     *
     */
    public function mute(Follower $follower): void
    {
        $statusMute = $this->statusRepo->findOneBy([
            "code" => "MUTED"
        ]);

        $follower->setStatus($statusMute);

        $this->followerRepo->save($follower);
    }

    /**
     *
     * @param array $relations
     *
    */
    public function block(array $relations): void
    {
        $statusBlock = $this->statusRepo->findOneBy([
            "code" => "BLOCK"
        ]);

        foreach($relations as $relation){
            $relation->setStatus($statusBlock);
            $this->followerRepo->save($relation);
        }
    }

}