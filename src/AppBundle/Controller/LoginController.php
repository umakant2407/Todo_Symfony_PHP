<?php

namespace AppBundle\Controller;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class LoginController extends Controller
{


    private $userManager;


    /**
     * @Route("/login", name="login", methods={"GET|POST"})
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        if($request->getMethod()=="POST" ) {
            $email_id = $request->get('email_id');
            $password = $request->get('password');
            $this->userManager = $this->container->get('app.user_manager');
            $user = $this->userManager->loginUser($email_id,$password);
            if ($user->getPassword()==$password) {
                session_destroy();
                session_start();
                $_SESSION["userId"]=$user->getId();
                return $this->redirectToRoute('displayEvent');
            }else{
                echo "Email-id or Password is Wrong";
            }
        }
        return $this->render('security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }
}