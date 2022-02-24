<?php

namespace AppBundle\Manager;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager as Doctrine;
use AppBundle\Entity\Event;
use AppBundle\Repository\EventRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * Event Manager
 */
class EventManager
{
    /**
     * @var EntityManager
     */
    private $em ;
    /**
     * @var Doctrine
     */
    private $doctrine;

    /**
     * Constructor
     * @param Doctrine                 $doctrine        - Doctrine
     */
    public function __construct(Doctrine $doctrine){
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getManager();
    }


    public function DisplayAll($eventRepository): Event
    {
        return $this->$eventRepository->getDoctrine()->getRepository(Event::class)->findBy([], ['id' => 'DESC']);

    }


    public function createEvent(int $userId,Event $event)
    {
        $repository = $this->em->getRepository(User::class);
        $user=$repository->findOneBy(array('id' => $userId ));
        $event->setUser($user);
        $this->em->persist($event);
        $this->em->flush();

    }


    public function updateStatus(Request $request,EntityManagerInterface $em){
        $event=new Event();
        $id = trim($request->request->get('id'));
        $entityManager = $this->eventRepository->getDoctrine()->getManager();
        $event = $this->eventRepository->getDoctrine()->getRepository(Event::class)->find($id);

        $event->setStatus( ! $event->getStatus());
        $entityManager->flush();
        return $this->eventRepository->redirectToRoute('event_list');
    }
}