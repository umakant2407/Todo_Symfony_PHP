<?php

namespace AppBundle\Tests\Controller;
use AppBundle\Entity\User;
use Doctrine\Common\Persistence\ManagerRegistry as Doctrine;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginControllerTest extends WebTestCase
{
    private $userManager;

    /**
     * Constructor
     */
    public function __construct(){
        parent::__construct();
    }

    public function testLoginAction()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('form')->count());

        $form = $crawler->selectButton('Sign in')->form();
        $form['_username'] = "umakant";
        $form['_password'] = "umakant";
        $client->submit($form);
        $crawler = $client->followRedirect();
        $this->assertSame(1, $crawler->filter('html:contains("umakant")')->count());

    }

}