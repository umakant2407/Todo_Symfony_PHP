<?php

namespace AppBundle\Tests\Controller;
use AppBundle\Entity\Event;
use AppBundle\Entity\User;
use Doctrine\Common\Persistence\ManagerRegistry as Doctrine;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class EventControllerTest extends WebTestCase
{

    /**
     * @var Client
     */
    private $client;
    private $em;
    private $event;
    private $eventManagerTest;


    /**
     * Constructor
     */
    public function __construct(){
        parent::__construct();
        $this->client = static::createClient();
    }



    /**
     * Test if event is well added by the add form
     */
    public function testCreate()
    {
        $this->logInAsUser();
        $crawler = $this->client->request('GET', '/User/Event');
        $form = $crawler->selectButton('Create')->form();
        $form['event[title]'] = 'Title test';
        $form['event[description]'] = 'description of event';
        $form['event[status]'] = 'done';
        $this->event = $this->client->submit($form);
        $crawler = $this->client->followRedirect();
        $response = $this->client->getResponse();
        $statusCode = $response->getStatusCode();
        $this->assertEquals(200, $statusCode);
        $this->assertSame(1, $crawler->filter('html:contains("New Event created Successfully")')->count());
    }


    /**
     * Test if event is well modified by the edit form
     */
    public function testUpdateEvent()
    {
        $this->logInAsUser();
        $id=1;
        $crawler = $this->client->request('GET', '/User/Event/Update/'.$id);
        $form = $crawler->selectButton('Update')->form();
        $form['event[title]'] = 'Title';
        $form['event[description]'] = 'This is updated one';
        $form['event[status]']='not done';
        $this->client->submit($form);
        $crawler = $this->client->followRedirect();
        $response = $this->client->getResponse();
        $statusCode = $response->getStatusCode();
        $this->assertEquals(200, $statusCode);
        $this->assertSame(1, $crawler->filter('html:contains("Event updated successfully")')->count());

    }

    /**
     * Display all event of login user
     */
    public function testdisplayEvent(){
        $this->logInAsUser();
        $id=1;
        $crawler = $this->client->request('GET', '/User/');
        $response = $this->client->getResponse();
        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("List Of Events")')->count());
    }


    /**
     * Simulate a login as an user (with ROLE_USER)
     */
    private function logInAsUser()
    {

        $crawler = $this->client->request('GET', '/login');
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('form')->count());

        $form = $crawler->selectButton('Sign in')->form();
        $form['_username'] = "umakant";
        $form['_password'] = "umakant";
        $this->client->submit($form);
        $crawler = $this->client->followRedirect();

    }


}