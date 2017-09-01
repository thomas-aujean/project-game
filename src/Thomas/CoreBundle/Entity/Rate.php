<?php

namespace Thomas\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rate
 *
 * @ORM\Table(name="rate")
 * @ORM\Entity(repositoryClass="Thomas\CoreBundle\Repository\RateRepository")
 */
class Rate
{
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
     * @ORM\Column(name="rate", type="string", length=255, nullable=true)
     */
    private $rate;

    /**
     * @ORM\ManyToOne(targetEntity="Thomas\UserBundle\Entity\User", inversedBy="rate")
     */
     private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Thomas\CoreBundle\Entity\Product", inversedBy="rate")
     */
     private $product;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set rate
     *
     * @param string $rate
     *
     * @return Rate
     */
    public function setRate($rate)
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * Get rate
     *
     * @return string
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Set user
     *
     * @param \Thomas\UserBundle\Entity\User $user
     *
     * @return Rate
     */
    public function setUser(\Thomas\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Thomas\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set product
     *
     * @param \Thomas\CoreBundle\Entity\Productr $product
     *
     * @return Rate
     */
    public function setProduct(\Thomas\CoreBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \Thomas\CoreBundle\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }
}
