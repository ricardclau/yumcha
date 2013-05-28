<?php

namespace Yumcha\Bundle\WebsiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * BubbleIngredientCategory
 *
 * @ORM\Table(name="bubble_ingredients_categories", uniqueConstraints={@ORM\UniqueConstraint(columns={"name"})})
 * @ORM\Entity(repositoryClass="Yumcha\Bundle\WebsiteBundle\Entity\BubbleIngredientCategoryRepository")
 */
class BubbleIngredientCategory
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
     * @var integer
     *
     * @ORM\Column(name="step", type="integer")
     */
    private $step;

    /**
     * @ORM\OneToMany(targetEntity="BubbleIngredient", mappedBy="category")
     */
    private $ingredients;

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
     * @return BubbleIngredientCategory
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
     * @return BubbleIngredientCategory
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
     * @return BubbleIngredientCategory
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
     * @return BubbleIngredientCategory
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
     * Set step
     *
     * @param integer $step
     * @return BubbleIngredientCategory
     */
    public function setStep($step)
    {
        $this->step = $step;
    
        return $this;
    }

    /**
     * Get step
     *
     * @return integer 
     */
    public function getStep()
    {
        return $this->step;
    }

    /**
     * Add ingredient
     *
     * @param BubbleIngredient $ingredient
     * @return BubbleIngredientCategory
     */
    public function addIngredient(BubbleIngredient $ingredient)
    {
        $this->ingredients[] = $ingredient;

        return $this;
    }

    /**
     * Remove ingredient
     *
     * @param BubbleIngredient $ingredient
     */
    public function removeIngredient(BubbleIngredient $ingredient)
    {
        $this->ingredients->removeElement($ingredient);
    }

    /**
     * Get ingredients
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIngredients()
    {
        return $this->ingredients;
    }

    public function __toString()
    {
        return $this->name;
    }

    public static function getSteps()
    {
        return [
            2 => 'Sabor',
            3 => 'Bubbles',
        ];
    }
}
