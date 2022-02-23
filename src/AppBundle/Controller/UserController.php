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
     * @Route("/User/", name="index")
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
     * @Route("/User/create", name="signUp", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function signUp(Request $request)
    {
        $path="signUp";
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->render('Registration/register.html.twig',array('form' => $form->createView(),'path'=>$path));
        }
        return new Response('Not Saved new product with id '.$user->getEmailId());
    }


}