<?php

namespace Thomas\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="Thomas\CoreBundle\Repository\ProductRepository")
 */
class Product
{
    /**
    * @ORM\OneToOne(targetEntity="Thomas\CoreBundle\Entity\ProductImage", cascade={"persist"})* @ORM\JoinColumn(nullable=false)
    * @ORM\JoinColumn(nullable=false)
    */
    private $image;

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
     * @ORM\Column(name="reference", type="string", length=255, unique=true)
     */
    private $reference;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="categoryId", type="integer")
     */
    private $categoryId;

    /**
     * @var int
     *
     * @ORM\Column(name="brandId", type="integer")
     */
    private $brandId;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2)
     */
    private $price;

    /**
     * @var int
     *
     * @ORM\Column(name="rates", type="integer")
     */
    private $rates;

    /**
     * @var int
     *
     * @ORM\Column(name="editorId", type="integer")
     */
    private $editorId;

    /**
     * @var int
     *
     * @ORM\Column(name="systemId", type="integer", nullable=true)
     */
    private $systemId;


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
     * Set reference
     *
     * @param string $reference
     *
     * @return Product
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Product
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
     * Set categoryId
     *
     * @param integer $categoryId
     *
     * @return Product
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;

        return $this;
    }

    /**
     * Get categoryId
     *
     * @return int
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * Set brandId
     *
     * @param integer $brandId
     *
     * @return Product
     */
    public function setBrandId($brandId)
    {
        $this->brandId = $brandId;

        return $this;
    }

    /**
     * Get brandId
     *
     * @return int
     */
    public function getBrandId()
    {
        return $this->brandId;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set rates
     *
     * @param integer $rates
     *
     * @return Product
     */
    public function setRates($rates)
    {
        $this->rates = $rates;

        return $this;
    }

    /**
     * Get rates
     *
     * @return int
     */
    public function getRates()
    {
        return $this->rates;
    }

    /**
     * Set editorId
     *
     * @param integer $editorId
     *
     * @return Product
     */
    public function setEditorId($editorId)
    {
        $this->editorId = $editorId;

        return $this;
    }

    /**
     * Get editorId
     *
     * @return int
     */
    public function getEditorId()
    {
        return $this->editorId;
    }

    /**
     * Set systemId
     *
     * @param integer $systemId
     *
     * @return Product
     */
    public function setSystemId($systemId)
    {
        $this->systemId = $systemId;

        return $this;
    }

    /**
     * Get systemId
     *
     * @return int
     */
    public function getSystemId()
    {
        return $this->systemId;
    }

    /**
     * Set image
     *
     * @param \Thomas\CoreBundle\Entity\ProductImage $image
     *
     * @return Product
     */
    public function setImage(\Thomas\CoreBundle\Entity\ProductImage $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \Thomas\CoreBundle\Entity\ProductImage
     */
    public function getImage()
    {
        return $this->image;
    }
}
