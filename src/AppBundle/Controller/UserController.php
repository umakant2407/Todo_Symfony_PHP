<?php

namespace AppBundle\Controller;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class UserController extends Controller
{


    private $userManager;

    /**
     * @Route("/Register", name="signUp", methods={"GET|POST"})
     * @param Request $request
     * @return Response
     */
    public function signUp(Request $request)
    {
        $path="signUp";
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted()  ) {
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $this->userManager = $this->get('app.user_manager');
            if(!$this->userManager->getUserByName($user->getName())) {
                $this->userManager->addUser($password, $user);
                $authenticationUtils = $this->get('security.authentication_utils');
                $error = $authenticationUtils->getLastAuthenticationError();
                $lastUsername = $authenticationUtils->getLastUsername();
                return $this->redirectToRoute('displayEvent');
            }else{
                $this->addFlash('warning', 'This User Name is Already Registered');
                return $this->redirectToRoute('signUp');
            }
        }
        return $this->render('Registration/register.html.twig',['form'=>$form->createView(),'path'=>$path]);
    }


    /**
     * @Route("/logout", name="logout")
     */
    public function logout(){
        //
    }
}