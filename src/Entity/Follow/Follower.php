<?php


namespace App\Entity\Follow;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Entity\User\User;

/**
 * Entity follower
 *
 * @ORM\Entity(repositoryClass="App\Repository\Follow\FollowerRepository")
 * @ORM\Table(name="follower",
 *    uniqueConstraints={
 *        @UniqueConstraint(name="follow_unique",
 *            columns={"user_one_id", "user_two_id"})
 *    }
 * )
 * @UniqueEntity(
 *     fields={"userOne", "userTwo"},
 *     errorPath="userOne",
 *     message="You already follow this user"
 * )
 */
class Follower
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User\User", inversedBy="follows")
     * @Assert\NotBlank()
     */
    private $userOne;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User\User", inversedBy="followers")
     * @Assert\NotBlank()
     */
    private $userTwo;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Follow\Status", inversedBy="followers")
     * @Assert\NotBlank()
     */
    private $status;

    /**
     * @param int $id
     *
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param User $userOne
     *
     * @return Follower
    */
    public function setUserOne(User $userOne): self
    {
        $this->userOne = $userOne;

        return $this;
    }

    /**
     *
     * @return User|null
    */
    public function getUserOne(): ?User
    {
        return $this->userOne;
    }

    /**
     * @param User $userTwo
     *
     * @return Follower
     */
    public function setUserTwo(User $userTwo): self
    {
        $this->userTwo = $userTwo;

        return $this;
    }

    /**
     *
     * @return User|null
     */
    public function getUserTwo(): ?User
    {
        return $this->userTwo;
    }

    /**
     * @param Status $status
     *
     * @return Follower
     */
    public function setStatus(Status $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     *
     * @return Status|null
     */
    public function getStatus(): ?Status
    {
        return $this->status;
    }

}