<?php

namespace AppBundle\Manager;

use AppBundle\Entity\User\Event;
use AppBundle\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EventManager
{
    private $eventRepository ;

    /**
     * Constructor
     * @param EventRepository   $eventRepository   - Event Repository
     */
    public function __construct(EventRepository $eventRepository){
        $this->eventRepository = $eventRepository;
    }


    public function DisplayAll($eventRepository): Event
    {
        return $this->$eventRepository->getDoctrine()->getRepository(Event::class)->findBy([], ['id' => 'DESC']);

    }


    public function createEvent(Request $request): \Symfony\Component\HttpFoundation\RedirectResponse
    {

        $title = trim($request->request->get('title'));
        $description = trim($request->request->get('description'));
        $status = trim($request->request->get('status'));
        if (empty($title))
            return $this->eventRepository->redirectToRoute('DisplayAll');
        $entityManager = $this->eventRepository->getDoctrine()->getManager();
        $event = new Event();
        $event->setTitle($title);
        $event->setDescription($description);
        $event->setStatus($status);
        $entityManager->persist($event);
        $entityManager->flush();
        return $this->eventRepository->redirectToRoute('DisplayAll');
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