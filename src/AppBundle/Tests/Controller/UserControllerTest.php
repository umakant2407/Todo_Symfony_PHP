<?php

namespace AppBundle\Tests\Controller;

use Doctrine\Common\Persistence\ManagerRegistry as Doctrine;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{

    /**
     * @var Client
     */
    private $client;


    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->client = static::createClient();
    }


    /**
     * Test if user is well redirected if not logged in
     */
    public function testIsRedirectedIfNotLoggedIn()
    {
        $client = static::createClient();
        $client->request('GET', '/User/');

        $response = $client->getResponse();

        $statusCode = $response->getStatusCode();
        $this->assertEquals(302, $statusCode);

        $crawler = $client->followRedirect();
        $response = $client->getResponse();
        $statusCode = $response->getStatusCode();

        $this->assertEquals(200, $statusCode);
    }

    /**
     * Test if user is well added by the add form
     */
    public function testSignUp()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/Register');

        $form = $crawler->selectButton('Create')->form();
        $form['user[name]'] = 'userAddTest';
        $form['user[password][first]'] = 'umakant';
        $form['user[password][second]'] = 'umakant';
        $form['user[email_id]'] = 'test@test.com';
        $form['user[mobile_number]'] = '0123456789';
        $client->submit($form);
        $crawler = $client->followRedirect();
        $response = $client->getResponse();
        $statusCode = $response->getStatusCode();
        $this->assertEquals(200, $statusCode);
        $this->assertSame(1, $crawler->filter('html:contains("TODO APP")')->count());
    }


}