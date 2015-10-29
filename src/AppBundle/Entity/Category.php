<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * MyEntity
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Category {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\OneToMany(targetEntity="Type", mappedBy="category")
     */
    private $types;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     * 
     */
    private $title;

   
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->types = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Category
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Add type
     *
     * @param \AppBundle\Entity\Type $type
     *
     * @return Category
     */
    public function addType(\AppBundle\Entity\Type $type)
    {
        $this->types[] = $type;

        return $this;
    }

    /**
     * Remove type
     *
     * @param \AppBundle\Entity\Type $type
     */
    public function removeType(\AppBundle\Entity\Type $type)
    {
        $this->types->removeElement($type);
    }

    /**
     * Get types
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTypes()
    {
        return $this->types;
    }
}
