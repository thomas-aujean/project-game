<?php
// src/Thomas/UserBundle/Entity/User.php

namespace Thomas\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="Thomas\UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
    * @ORM\Column(name="id", type="integer")
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    protected $id;

    /**
    * @var string
    *
    * @ORM\Column(name="address", type="string", length=255)
    */
    private $address;

    /**
    * @var string
    *
    * @ORM\Column(name="zipcode", type="string", length=255)
    * @Assert\Length(max=5, minMessage="Le code postal ne doit pas dépasser {{ limit }} chiffres.")
    * @Assert\Type(type="integer", message="Merci de ne saisir que des nombres.")
    */
    private $zipcode;

    /**
    * @var string
    *
    * @ORM\Column(name="city", type="string", length=255)
    */
    private $city;

       /**
     * Set address
     *
     * @param string $address
     *
     * @return User
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set zipcode
     *
     * @param string $zipcode
     *
     * @return User
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    /**
     * Get zipcode
     *
     * @return string
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return User
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }
}
