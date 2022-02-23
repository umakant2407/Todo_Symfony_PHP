<?php

namespace AppBundle\Entity;
use AppBundle\Entity\Event;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
//use Symfony\Component\Validator\Constraints as Assert;

/**
* User
*
 * @ORM\Table(name="user")
 * @ORM\Entity
 */

class User implements \Symfony\Component\Security\Core\User\UserInterface
{


    /**
     * @var Event
     *
     * @ORM\OneToMany(targetEntity="Event", mappedBy="user")
     */
    private $events;

    public function __construct()
    {
        $this->events = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getEvents()
    {
        return $this->events;
    }


    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(name="email_id", type="string", length=255)
     */
    private $email_id ;
    /**
     * @var string
     * @ORM\Column(name="password", type="string", length=10)
     */
    private $password ;

    /**
     * @var string
     *
     * @ORM\Column(name="mobile_number", type="string", length=10)
     */
    private $mobile_number;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getEmailId()
    {
        return $this->email_id;
    }

    /**
     * @param string $email_id
     */
    public function setEmailId(string $email_id)
    {
        $this->email_id = $email_id;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getMobileNumber()
    {
        return $this->mobile_number;
    }

    /**
     * @param string $mobile_number
     */
    public function setMobileNumber(string $mobile_number)
    {
        $this->mobile_number = $mobile_number;
    }

    public function getPlainPassword()
    {
        return $this->getPassword();
    }

    public function getRoles()
    {
        // TODO: Implement getRoles() method.
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function getUsername()
    {
        // TODO: Implement getUsername() method.
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
}