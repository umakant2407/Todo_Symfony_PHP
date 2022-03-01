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
    private $userRepository;


    /**
     * Constructor
     * @param Doctrine         $doctrine        - Doctrine
     */
    public function __construct(Doctrine $doctrine){
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getManager();
        $this->userRepository = $this->em->getRepository(User::class);
    }

    public function addUser( string $password,User $user){
        $user->setPassword($password);
        $this->em->persist($user);
        $this->em->flush();
    }


    public function getUserByName(string $name): bool
    {
        $user=$this->userRepository->findOneBy(array('name'=>$name));
        If($user){
            return true;
        }else{
            return false;
        }
    }


}