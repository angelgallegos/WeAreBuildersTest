<?php


namespace App\Tests\Functional\User;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;

class RegisterTest extends WebTestCase
{

    protected function setUp()
    {
        $this->purgeDatabase();
    }

    public function testUserRegistration()
    {
        $client = $this->createClient();
        $client->request(
            'POST',
            'user/register',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json', 'HTTP_ACCEPT' => 'application/json'],
            '{"name": "John",
	                "last_name": "Doe",
	                "email":"johndoe@mail.com",
    	            "birthday": "1990-01-01",
	                "username": "jdoe",
	                "plain_password":{
                        "first":"jdoe",
                        "second":"jdoe"
                    }}'
        );

        $this->assertSame(
            Response::HTTP_CREATED,
            $client->getResponse()->getStatusCode()
        );
    }

    public function testUserRegistrationFails()
    {
        $client = $this->createClient();
        $client->request(
            'POST',
            'user/register',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json', 'HTTP_ACCEPT' => 'application/json'],
            '{"name": "John",
	                "last_name": "Doe",
	                "email":"johndoe@mail",
    	            "birthday": "1990-01-01",
	                "username": "jdoe",
	                "plain_password":{
                        "first":"jdoe",
                        "second":"jdoe"
                    }}'
        );

        $this->assertSame(
            Response::HTTP_UNPROCESSABLE_ENTITY,
            $client->getResponse()->getStatusCode()
        );
    }

    private function purgeDatabase()
    {
        self::bootKernel();

        $purger = new ORMPurger(self::$container->get('doctrine.orm.default_entity_manager'));
        $purger->purge();
    }
}