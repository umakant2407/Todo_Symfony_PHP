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

    /**
     * Routing to get all Event
     * @Route("User/{userId}/Event", name="Event", Methods={"GET"})
     * @return Response
     */
    public function eventAction(int $userId): Response
    {
        $path="create_event";
        $event=new  Event();
        $form = $this->createForm(EventType::class,$event);
        return $this->render('Event/createEvent.html.twig',['form'=>$form->createView(),'path'=>$path,'userId'=>$userId]);

    }

    /**
     * @Route("/User/{userId}/Event", name="create_event", methods={"POST"})
     */
    public function create(Request $request,int $userId)
    {
//        $userRepository=new UserRepository();
        $path="create_event";
        $event =new Event();
        $form = $this->createForm(EventType::class,$event);
        $form->handleRequest($request);
        if ($form->isSubmitted() ) {
            $entityManager = $this->getDoctrine()->getManager();
            $repository = $entityManager->getRepository(User::class);
            $user=$repository->findOneBy(array('id' => $userId ));
            $event->setUser($user);
            $entityManager->persist($event);
            $entityManager->flush();
            return $this->redirectToRoute('displayEvent',['userId' => $userId]);
        }
        return new Response('Not Saved new Event with Title '.$event->getTitle());

    }

    /**
     * @Route("/User/{userId}/Event/Update/{eventId}", name="updateAction", methods={"GET"})
     */
    public function updateAction(int $eventId,int $userId)
    {
        $path="update";
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository(Event::class);
        $event = $repository->findOneBy(array('id' => $eventId));
        $form = $this->createForm(EventType::class,$event);
        return $this->render('Event/updateEvent.html.twig',['form'=>$form->createView(),'path'=>$path,'eventId'=>$eventId,'userId'=>$userId]);
    }

    /**
     * @Route("/User/{userId}/Event/Update/{eventId}", name="update", methods={"POST"})
     */
    public function update(Request $request,int $eventId,int $userId)
    {
        $path="update";
        $event =new Event();
        $form = $this->createForm(EventType::class,$event);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $title=$form->get('title')->getData();
            $description=$form->get('description')->getData();
            $status=$form->get('status')->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $repository = $entityManager->getRepository(Event::class);
            $event = $repository->findOneBy(array('id' => $eventId));
            $event->setStatus($status);
            $event->setTitle($title);
            $event->setDescription($description);
            $entityManager->persist($event);
            $entityManager->flush();
            return $this->redirectToRoute('displayEvent',['userId' => $userId]);
        }
    }

    /**
     * @Route("/User/{userId}", name="displayEvent", methods={"GET"})
     */
    public function displayEvent(int $userId){
        $eventList=new ArrayCollection();
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository(Event::class);
        $eventList = $repository->findBy(array('user' => $userId));
        return $this->render('Event/eventDisplay.html.twig',['eventList'=>$eventList,'userId'=>$userId]);
    }


}