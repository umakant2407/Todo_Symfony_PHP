<?php

namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{


    /**
     * @Route("/", name="create_user", methods={"POST"})
     */
    public function signUp(Request $request)
    {
        $name = trim($request->request->get('name'));
        $email_id = trim($request->request->get('email_id'));
        $password = trim($request->request->get('password'));
        $mobile_number = trim($request->request->get('mobile_number'));
        $entityManager = $this->getDoctrine()->getManager();
        $user = new User();
        $user->setEmailId($email_id);
        $user->setPassword($password);
        $user->setName($name);
        $user->setMobileNumber($mobile_number);
        $entityManager->persist($user);
        $entityManager->flush();
    }


    /**
     * @Route("/{email_id}{passawrd}", name="login_user", methods={"GET"})
     */
    public function login(Request $request)
    {
        $user= new User();
        $email_id = trim($request->request->get('email_id'));
        $password = trim($request->request->get('password'));
        $entityManager = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository(User::class)->find($email_id);
        $originalPassword=$user->getPassword();
        if($password==$originalPassword){
            return $user->getEvents();
        }else{
            return "Email Id or Password is incorrect";
        }
    }
}