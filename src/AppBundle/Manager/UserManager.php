<?php
//
//namespace AppBundle\Manager;
//use AppBundle\Entity\User;
//use AppBundle\Repository\UserRepository;
//use Symfony\Component\Form\Form;
//use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
//
//class UserManager
//{
//
//    private $userRepository ;
//
//    /**
//     * Constructor
//     * @param UserRepository   $userRepository   - User Repository
//     */
//    public function __construct(UserRepository $userRepository){
//        $this->userRepository = $userRepository;
//    }
//
//    public function addUser(Form $form, User $user,UserPasswordEncoderInterface $passwordEncoder){
//
//        if ($form->isSubmitted() && $form->isValid()) {
//
//            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
//            $user->setPassword($password);
//
//
//            $entityManager = $this->userRepository->getDoctrine()->getManager();
//            $entityManager->persist($user);
//            $entityManager->flush();
//
//            return $this->userRepository->redirectToRoute('replace_with_some_route');
//        }
//
//        return $this->userRepository->render(
//            'registration/register.html.twig',
//            array('form' => $form->createView())
//        );
//    }
//
//
//    public function loginUser(Request $request){
//
//        $user= new User();
//        $email_id = trim($request->request->get('email_id'));
//        $password = trim($request->request->get('password'));
//        $entityManager = $this->userRepository->getDoctrine()->getManager();
//        $user = $this->userRepository->getDoctrine()->getRepository(User::class)->find($email_id);
//        $originalPassword=$user->getPassword();
//        if($password==$originalPassword){
//            return $user->getEvents();
//        }else{
//            return "Email Id or Password is incorrect";
//        }
//
////    }
//
//
//}