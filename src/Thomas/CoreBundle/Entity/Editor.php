<?php

namespace Thomas\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Editor
 *
 * @ORM\Table(name="editor")
 * @ORM\Entity(repositoryClass="Thomas\CoreBundle\Repository\EditorRepository")
 */
class Editor
{

    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="editor")
     */
    private $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
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
     * @return Editor
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
}

