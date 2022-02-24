<?php

namespace AppBundle\Controller;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{

    /**
     * @Route("/Login", name="start" ,methods={"GET"})
     * @return Response
     */
    public function startAction(): Response
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }



    /**
     * @Route("/Login", name="login", methods={"POST"})
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        if($request->getMethod()=="POST") {
            $email_id = $request->get('email_id');
            $password = $request->get('password');
            $entityManager = $this->getDoctrine()->getManager();
            $repository = $entityManager->getRepository(User::class);
            $user = $repository->findOneBy(array('email_id' => $email_id, 'password' => $password));
            if (!$user) {
                echo "Email-id is not Registered Please SignUp";
                return $this->redirectToRoute('start');
            }else{
                $userId=$user->getId();
                return $this->redirectToRoute('displayEvent',['userId' => $userId]);
            }
        }
    }
}