<?php

namespace AppBundle\Controller;
use AppBundle\Entity\User;
use AppBundle\Form\EventType;
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
     * @Route("/Event/", name="Event")
     * @return Response
     */
    public function eventAction(): Response
    {
        $path="create_event";
        $event=new  Event();
        $form = $this->createForm(EventType::class,$event);
        return $this->render('Event/event.html.twig',['form'=>$form->createView(),'path'=>$path]);

    }

    /**
     * @Route("/Event/create", name="create_event", methods={"POST"})
     */
    public function create(Request $request)
    {
        $path="create_event";
        $event =new Event();
        $event->setId(1);
        $form = $this->createForm(EventType::class,$event);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $repository = $entityManager->getRepository(User::class);
            $id=1;
            $user=$repository->findOneBy(array('id' => $id ));
            $event->setUser($user);
            $entityManager->persist($event);
            $entityManager->flush();
            return $this->render('Event/event.html.twig',['form'=>$form->createView(),'path'=>$path]);
        }
        return new Response('Not Saved new Event with id '.$event->getTitle());

    }

    /**
     * @Route("/Event/Update", name="updateAction")
     */
    public function updateAction()
    {
        echo "Change your Status";
        $path="update";
        $event=new  Event();
        $form = $this->createForm(EventType::class,$event);
        return $this->render('Event/event.html.twig',['form'=>$form->createView(),'path'=>$path]);
    }

    /**
     * @Route("/Event/Update/", name="update", methods={"POST"})
     */
    public function update(Request $request)
    {
        $path="update";
        $event =new Event();
        $form = $this->createForm(EventType::class,$event);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $title=$form->get('title')->getData();
            $description=$form->get('description')->getData();
            $status=$form->get('status')->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $repository = $entityManager->getRepository(Event::class);
            $event = $repository->findOneBy(array('title' => $title, 'description' => $description));
            $event->setStatus($status);
            $entityManager->persist($event);
            $entityManager->flush();
            echo "Status got updated\n Create another Event";
        }
        return $this->render('Event/event.html.twig',['form'=>$form->createView(),'path'=>$path]);
    }

    /**
     * @Route("/Event/{id}", name="displayAction")
     */
    public function displayAction(int $id){
        $eventList=new ArrayCollection();
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository(Event::class);
        $eventList = $repository->findAll(array('User_id' => $id));
        return $this->render('Event/eventDisplay.html.twig',['eventList'=>$eventList]);
    }


}