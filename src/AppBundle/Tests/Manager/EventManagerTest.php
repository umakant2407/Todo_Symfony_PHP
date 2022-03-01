<?php

namespace AppBundle\Tests\Manager;

use AppBundle\Entity\Event;
use AppBundle\Entity\User;
use Doctrine\Common\Persistence\ManagerRegistry as Doctrine;

class EventManagerTest
{

    private $em ;
    private $doctrine;
    private $eventRepository;
    private $userRepository;
    /**
     * Constructor
     * @param Doctrine         $doctrine        - Doctrine
     */
    public function __construct(Doctrine $doctrine){
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getManager();
        $this->userRepository = $this->em->getRepository(User::class);
        $this->eventRepository = $this->em->getRepository(Event::class);
    }

    public function getEventByName(String $userName){
        return $this->userRepository->findOneBy(array('name' => $userName));
    }


}