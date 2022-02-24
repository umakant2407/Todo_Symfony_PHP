<?php

namespace AppBundle\Controller;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * @Route("/Register/", name="index", methods={"GET"})
     * @return Response
     */
    public function index(): Response
    {
        $path="signUp";
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        return $this->render('Registration/register.html.twig',['form'=>$form->createView(),'path'=>$path]);
    }

    /**
     * @Route("/Register", name="signUp", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function signUp(Request $request)
    {
        $path="signUp";
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() ) {
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $userId=$user->getId();
            return $this->redirectToRoute('displayEvent',['userId' => $userId]);
        }
        echo "Please Try again";
        return $this->redirectToRoute('start');
    }


}