<?php

namespace Thomas\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Statute
 *
 * @ORM\Table(name="statute")
 * @ORM\Entity(repositoryClass="Thomas\CoreBundle\Repository\StatuteRepository")
 */
class Statute
{

    /**
     * @ORM\OneToMany(targetEntity="MyOrder", mappedBy="statute")
     */
    private $orders;
    
    public function __construct()
    {
        $this->orders = new ArrayCollection();
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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Statute
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add order
     *
     * @param \Thomas\CoreBundle\Entity\MyOrder $order
     *
     * @return Statute
     */
    public function addOrder(\Thomas\CoreBundle\Entity\MyOrder $order)
    {
        $this->orders[] = $order;

        return $this;
    }

    /**
     * Remove order
     *
     * @param \Thomas\CoreBundle\Entity\MyOrder $order
     */
    public function removeOrder(\Thomas\CoreBundle\Entity\MyOrder $order)
    {
        $this->orders->removeElement($order);
    }

    /**
     * Get orders
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrders()
    {
        return $this->orders;
    }
}
