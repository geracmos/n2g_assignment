<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="customer")
 *
 * 
 * A customer entity consists of ID, first name, last name and email address.
 *
 * @author Gerasimos
 */
class Customer
{ 
    /**
     * @ORM\Column(type="integer", name="id")
     * @ORM\Id
     */
    private $id;
    
    /**
     * @ORM\Column(type="string", name="first_name", length=100)
     */
    private $firstName;
    
    /**
     * @ORM\Column(type="string", name="last_name", length=100)
     */
    private $lastName;
    
    /**
     * @ORM\Column(type="string", name="email", length=100)
     */
    private $email;
    
    /**
     * Get customer's id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Set customer's id
     *
     * @return Customer
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    
    /**
     * Get customer's fist name
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }
    
    /**
     * Set customer's fist name
     *
     * @return Customer
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }
    
    /**
     * Get customer's last name
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set customer's last name
     *
     * @return Customer
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }
    
    /**
     * Get customer's email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * Set customer's email
     *
     * @return Customer
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }
}