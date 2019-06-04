<?php


namespace App\Tests\Unit\Entity\User;

use \DateTime;
use App\Entity\User\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{
    /**
     * @var User
     */
    protected $object;

    protected $validator;

    protected function setUp()
    {
        $this->object = new User();

        self::bootKernel();

        $this->validator = static::$kernel->getContainer()->get('validator');
    }

    public function testGettersAndSetters()
    {

        $this->assertNull($this->object->getId());

        $date = new DateTime();

        $this->object->setBirthday($date);
        $this->assertEquals($date, $this->object->getBirthday());

        $this->object->setName("Test Name");
        $this->assertEquals("Test Name", $this->object->getName());

        $this->object->setLastName("Test LastName");
        $this->assertEquals("Test LastName", $this->object->getLastName());

        $this->object->setBiography("Biography");
        $this->assertEquals("Biography", $this->object->getBiography());
    }

    public function testValidators()
    {

        $date = new DateTime();

        $this->object->setBirthday($date);
        $this->object->setName("Test Name");
        $this->object->setUsername("username");
        $this->object->setLastName("Test LastName");
        $this->object->setEmail("angel@gallegos.com");
        $this->object->setBiography("angel@gallegos.com");


        $errors = $this->validator->validate($this->object);

        $this->assertEquals(0, count($errors));
    }

}