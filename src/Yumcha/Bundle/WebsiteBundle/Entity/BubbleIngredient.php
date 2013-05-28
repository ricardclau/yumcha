<?php

namespace Yumcha\Bundle\WebsiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * BubbleIngredient
 *
 * @ORM\Table(name="bubble_ingredients", uniqueConstraints={@ORM\UniqueConstraint(columns={"name"})})
 * @ORM\Entity(repositoryClass="Yumcha\Bundle\WebsiteBundle\Entity\BubbleIngredientRepository")
 */
class BubbleIngredient
{
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
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="title_ca", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $titleCa;

    /**
     * @var string
     *
     * @ORM\Column(name="title_es", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $titleEs;

    /**
     * @var string
     *
     * @ORM\Column(name="title_en", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $titleEn;

    /**
     * @ORM\ManyToOne(targetEntity="BubbleIngredientCategory", inversedBy="ingredients")
     * @Assert\NotNull()
     */
    private $category;

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
     * Set name
     *
     * @param string $name
     * @return BubbleIngredient
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
     * Set titleCa
     *
     * @param string $titleCa
     * @return BubbleIngredient
     */
    public function setTitleCa($titleCa)
    {
        $this->titleCa = $titleCa;
    
        return $this;
    }

    /**
     * Get titleCa
     *
     * @return string 
     */
    public function getTitleCa()
    {
        return $this->titleCa;
    }

    /**
     * Set titleEs
     *
     * @param string $titleEs
     * @return BubbleIngredient
     */
    public function setTitleEs($titleEs)
    {
        $this->titleEs = $titleEs;
    
        return $this;
    }

    /**
     * Get titleEs
     *
     * @return string 
     */
    public function getTitleEs()
    {
        return $this->titleEs;
    }

    /**
     * Set titleEn
     *
     * @param string $titleEn
     * @return BubbleIngredient
     */
    public function setTitleEn($titleEn)
    {
        $this->titleEn = $titleEn;
    
        return $this;
    }

    /**
     * Get titleEn
     *
     * @return string 
     */
    public function getTitleEn()
    {
        return $this->titleEn;
    }

    /**
     * Set category
     *
     * @param \Yumcha\Bundle\WebsiteBundle\Entity\BubbleIngredientCategory $category
     * @return Pintura
     */
    public function setCategory(BubbleIngredientCategory $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Yumcha\Bundle\WebsiteBundle\Entity\BubbleIngredientCategory
     */
    public function getCategory()
    {
        return $this->category;
    }
}
