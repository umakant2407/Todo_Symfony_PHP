<?php

namespace AppBundle\Controller;
use AppBundle\Entity\User;
use AppBundle\Form\EventType;
use AppBundle\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Event;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Manager\EventManager;

class EventController extends  Controller
{

    private  $eventManager;

    public function __construct(){

    }

    /**
     * @Route("/User/Event", name="create_event", methods={"GET|POST"})
     */
    public function create(Request $request)
    {
        $path="create_event";
        $event =new Event();
        $form = $this->createForm(EventType::class,$event);
        $form->handleRequest($request);
        if ($form->isSubmitted() ) {
            $this->eventManager = $this->get('app.event_manager');
            $this->eventManager->createEvent($event,$this->getUser());
            return $this->redirectToRoute('displayEvent');
        }
        return $this->render('Event/createEvent.html.twig',['form'=>$form->createView(),'path'=>$path, 'eventId'=>$event->getId() ,'userName'=>$this->getUser()->getName()]);

    }


    /**
     * @Route("/User/Event/Update/{eventId}", name="updateAction", methods={"GET|POST"})
     */
    public function update(Request $request,int $eventId)
    {

        $this->eventManager = $this->get('app.event_manager');
        $path="updateAction";
        $event =$this->eventManager->getEventById($eventId);
        $form = $this->createForm(EventType::class,$event);
        $form->handleRequest($request);
        if ($form->isSubmitted() ) {
            $this->eventManager->updateStatus($form, $eventId);
            return $this->redirectToRoute('displayEvent');
        }
        return $this->render('Event/updateEvent.html.twig',
            ['form'=>$form->createView(),'path'=>$path,
                'eventId'=>$eventId,'userName'=>$this->getUser()->getName()]);
    }

    /**
     * @Route("/User/", name="displayEvent", methods={"GET"})
     */
    public function displayEvent(){
        $this->eventManager = $this->container->get('app.event_manager');
        $eventList = $this->eventManager->displayAllByUser($this->getUser());
        return $this->render('Event/eventDisplay.html.twig',
            ['eventList'=>$eventList ,'userName'=>$this->getUser()->getName()]);
    }


}