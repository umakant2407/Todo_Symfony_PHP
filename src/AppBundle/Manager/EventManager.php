<?php

namespace AppBundle\Manager;
use AppBundle\Entity\User;
use Doctrine\Common\Persistence\ManagerRegistry as Doctrine;
use AppBundle\Entity\Event;
use Symfony\Component\Form\Form;


/**
 * Event Manager
 */
class EventManager
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

    public function createEvent(Event $event)
    {
        $user= $this->userRepository->findOneBy(array('id' => $_SESSION["userId"] ));
        $event->setUser($user);
        $this->em->persist($event);
        $this->em->flush();
    }

    public function updateStatusHelper(int $eventId){
        return $event = $this->eventRepository->findOneBy(array('id' => $eventId));
    }

    public function updateStatus(Form $form,int $eventId){
        $title=$form->get('title')->getData();
        $description=$form->get('description')->getData();
        $status=$form->get('status')->getData();
        $event = $this->eventRepository->findOneBy(array('id' => $eventId));
        $event->setStatus($status);
        $event->setTitle($title);
        $event->setDescription($description);
        $this->em->persist($event);
        $this->em->flush();
    }

    public function displayAll()
    {
        return $this->eventRepository->findBy(array('user' => $_SESSION["userId"]));

    }
}