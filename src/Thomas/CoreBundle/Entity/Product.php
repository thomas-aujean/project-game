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
    * @ORM\OneToOne(targetEntity="Thomas\CoreBundle\Entity\ProductImage", cascade={"persist", "remove"})
    */
    private $productImage;

    /**
    * @ORM\ManyToOne(targetEntity="Thomas\CoreBundle\Entity\Brand", inversedBy="products")
    * @ORM\JoinColumn(name="brand_id", referencedColumnName="id")
    */
    private $brand;

    /**
    * @ORM\ManyToOne(targetEntity="Thomas\CoreBundle\Entity\Editor", inversedBy="products")
    * @ORM\JoinColumn(name="editor_id", referencedColumnName="id")
    */
    private $editor;

    /**
    * @ORM\ManyToOne(targetEntity="Thomas\CoreBundle\Entity\ProductCategory", inversedBy="products")
    * @ORM\JoinColumn(name="product_category_id", referencedColumnName="id")
    */
    private $productCategory;

    /**
    * @ORM\ManyToOne(targetEntity="Thomas\CoreBundle\Entity\System", inversedBy="products")
    * @ORM\JoinColumn(name="system_id", referencedColumnName="id")
    */
    private $system;

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
     *
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2)
     */
    private $price;

    /**
     * @var int
     *
     * @ORM\Column(name="rates", type="integer", nullable=true)
     */
    private $rates;






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
     * @return integer
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
     * @return integer
     */
    public function getBrandId()
    {
        return $this->brandId;
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
     * @return integer
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
     * @return integer
     */
    public function getSystemId()
    {
        return $this->systemId;
    }

    /**
     * Set productImage
     *
     * @param \Thomas\CoreBundle\Entity\ProductImage $productImage
     *
     * @return Product
     */
    public function setProductImage(\Thomas\CoreBundle\Entity\ProductImage $productImage = null)
    {
        $this->productImage = $productImage;

        return $this;
    }

    /**
     * Get productImage
     *
     * @return \Thomas\CoreBundle\Entity\ProductImage
     */
    public function getProductImage()
    {
        return $this->productImage;
    }

    /**
     * Set brand
     *
     * @param \Thomas\CoreBundle\Entity\Brand $brand
     *
     * @return Product
     */
    public function setBrand(\Thomas\CoreBundle\Entity\Brand $brand = null)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return \Thomas\CoreBundle\Entity\Brand
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set editor
     *
     * @param \Thomas\CoreBundle\Entity\Editor $editor
     *
     * @return Product
     */
    public function setEditor(\Thomas\CoreBundle\Entity\Editor $editor = null)
    {
        $this->editor = $editor;

        return $this;
    }

    /**
     * Get editor
     *
     * @return \Thomas\CoreBundle\Entity\Editor
     */
    public function getEditor()
    {
        return $this->editor;
    }

    /**
     * Set productCategory
     *
     * @param \Thomas\CoreBundle\Entity\ProductCategory $productCategory
     *
     * @return Product
     */
    public function setProductCategory(\Thomas\CoreBundle\Entity\ProductCategory $productCategory = null)
    {
        $this->productCategory = $productCategory;

        return $this;
    }

    /**
     * Get productCategory
     *
     * @return \Thomas\CoreBundle\Entity\ProductCategory
     */
    public function getProductCategory()
    {
        return $this->productCategory;
    }

    /**
     * Set system
     *
     * @param \Thomas\CoreBundle\Entity\System $system
     *
     * @return Product
     */
    public function setSystem(\Thomas\CoreBundle\Entity\System $system = null)
    {
        $this->system = $system;

        return $this;
    }

    /**
     * Get system
     *
     * @return \Thomas\CoreBundle\Entity\System
     */
    public function getSystem()
    {
        return $this->system;
    }


}
