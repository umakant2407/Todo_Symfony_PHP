<?php

namespace AppBundle\Manager;
use AppBundle\Entity\Event;
use AppBundle\Entity\User;
use Doctrine\Common\Persistence\ManagerRegistry as Doctrine;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * Event Manager
 */
class UserManager
{

    private $em ;
    private $doctrine;
    private $eventRepository;
    private $userRepository;
    /**
     * Constructor
     * @param Doctrine         $doctrine        - Doctrine
     */
    public function __construct(Doctrine $doctrine){
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getManager();
        $this->userRepository = $this->em->getRepository(User::class);
        $this->eventRepository = $this->em->getRepository(Event::class);
    }

    public function addUser( string $password,User $user){
        $user->setPassword($password);
        $this->em->persist($user);
        $this->em->flush();
    }


    public function loginUser(string $email_id,string $password){
        return $this->userRepository->findOneBy(array('email_id'=>$email_id));
    }


}