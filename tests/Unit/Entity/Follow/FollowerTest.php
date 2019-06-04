<?php


namespace App\Tests\Unit\Entity\Follow;

use App\Entity\Follow\Follower;
use App\Entity\Follow\Status;
use App\Entity\User\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FollowerTest extends KernelTestCase
{
    /**
     * @var User
     */
    protected $object;

    protected $validator;

    protected function setUp()
    {
        $this->object = new Follower();

        self::bootKernel();

        $this->validator = static::$kernel->getContainer()->get('validator');
    }

    public function testGettersAndSetters()
    {

        $this->assertNull($this->object->getId());

        $userOne = new User();
        $userTwo = new User();
        $status = new Status();

        $this->object->setUserOne($userOne);
        $this->assertEquals($userOne, $this->object->getUserOne());

        $this->object->setUserTwo($userTwo);
        $this->assertEquals($userTwo, $this->object->getUserTwo());

        $this->object->setStatus($status);
        $this->assertEquals($status, $this->object->getStatus());
    }

    public function testValidators()
    {

        $userOne = new User();
        $userTwo = new User();
        $status = new Status();

        $this->object->setUserOne($userOne);
        $this->object->setUserTwo($userTwo);
        $this->object->setStatus($status);

        $errors = $this->validator->validate($this->object);

        $this->assertEquals(0, count($errors));
    }

}