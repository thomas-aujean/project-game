<?php

namespace Thomas\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MyOrder
 *
 * @ORM\Table(name="my_order")
 * @ORM\Entity(repositoryClass="Thomas\CoreBundle\Repository\MyOrderRepository")
 */
class MyOrder
{
    /**
     * @ORM\ManyToOne(targetEntity="Thomas\UserBundle\Entity\User", inversedBy="myOrder")
     */
     private $user;

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
     * @ORM\Column(name="coupon", type="integer")
     */
    private $coupon;

    /**
     * @var string
     *
     * @ORM\Column(name="amount", type="decimal", precision=10, scale=2)
     */
    private $amount;

    /**
     * @var string
     *
     * @ORM\Column(name="detail", type="text")
     */
    private $detail;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    public function __construct()
    {
        $this->created = new \DateTime();
    }


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
     * Set amount
     *
     * @param string $amount
     *
     * @return MyOrder
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return MyOrder
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set detail
     *
     * @param string $detail
     *
     * @return MyOrder
     */
    public function setDetail($detail)
    {
        $this->detail = $detail;

        return $this;
    }

    /**
     * Get detail
     *
     * @return string
     */
    public function getDetail()
    {
        return $this->detail;
    }

    /**
     * Set user
     *
     * @param \Thomas\UserBundle\Entity\User $user
     *
     * @return MyOrder
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
     * Set coupon
     *
     * @param integer $coupon
     *
     * @return MyOrder
     */
    public function setCoupon($coupon)
    {
        $this->coupon = $coupon;

        return $this;
    }

    /**
     * Get coupon
     *
     * @return integer
     */
    public function getCoupon()
    {
        return $this->coupon;
    }
}
