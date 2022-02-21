<?php

namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Event;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EventController extends  Controller
{

    /**
     * @Route("/lucky/number")
     * @throws \Exception
     */
    public function numberAction(): Response
    {
        $number = random_int(0, 100);

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }

    /**
     * @Route("/Event/", name="event_list", methods={"GET"})
     */
    public function index(): \Symfony\Component\HttpFoundation\Response
    {
        $event = $this->getDoctrine()->getRepository(Event::class)->findBy([], ['id' => 'DESC']);
        return $this->render('index.html.twig', ['Event' => $event]);

    }

    /**
     * @Route("/Event/", name="create_event", methods={"POST"})
     */
    public function create(Request $request): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        $title = trim($request->request->get('title'));
        $description = trim($request->request->get('description'));
        $status = trim($request->request->get('status'));
        if (empty($title))
            return $this->redirectToRoute('event_list');
        $entityManager = $this->getDoctrine()->getManager();
        $event = new Event();
        $event->setTitle($title);
        $event->setDescription($description);
        $event->setStatus($status);
        $entityManager->persist($event);
        $entityManager->flush();

        return $this->redirectToRoute('event_list');
    }

    /**
     * @Route("/Event/change-status/{id}", name="change_status", methods={"PATCH"})
     */
    public function changeStatus(Request $request): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        $event=new Event();
        $id = trim($request->request->get('id'));
        $entityManager = $this->getDoctrine()->getManager();
        $event = $this->getDoctrine()->getRepository(Event::class)->find($id);

        $event->setStatus( ! $event->getStatus());
        $entityManager->flush();
        return $this->redirectToRoute('event_list');
    }

}