<?php

namespace Yumcha\Bundle\WebsiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * IcecreamCategory
 *
 * @ORM\Table("icecream_categories", uniqueConstraints={@ORM\UniqueConstraint(columns={"name"})})
 * @ORM\Entity(repositoryClass="Yumcha\Bundle\WebsiteBundle\Entity\IcecreamCategoryRepository")
 */
class IcecreamCategory
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
     * @ORM\OneToMany(targetEntity="IcecreamFlavour", mappedBy="category")
     */
    private $flavours;

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
     * @return IcecreamCategory
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
     * @return IcecreamCategory
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
     * @return IcecreamCategory
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
     * @return IcecreamCategory
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
     * Add flavour
     *
     * @param IcecreamFlavour $flavour
     * @return IcecreamCategory
     */
    public function addFlavour(IcecreamFlavour $flavour)
    {
        $this->flavours[] = $flavour;

        return $this;
    }

    /**
     * Remove flavour
     *
     * @param IcecreamFlavour $flavour
     */
    public function removeFlavour(IcecreamFlavour $flavour)
    {
        $this->flavours->removeElement($flavour);
    }

    /**
     * Get pinturas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFlavours()
    {
        return $this->flavours;
    }

    public function __toString()
    {
        return $this->name;
    }
}
