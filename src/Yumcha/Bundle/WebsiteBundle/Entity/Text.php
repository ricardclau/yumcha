<?php

namespace Yumcha\Bundle\WebsiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Text
 *
 * @ORM\Table(name="texts", uniqueConstraints={@ORM\UniqueConstraint(columns={"name"})})
 * @ORM\Entity(repositoryClass="Yumcha\Bundle\WebsiteBundle\Entity\TextRepository")
 */
class Text
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
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="text_ca", type="text")
     */
    private $textCa;

    /**
     * @var string
     *
     * @ORM\Column(name="text_es", type="text")
     */
    private $textEs;

    /**
     * @var string
     *
     * @ORM\Column(name="text_en", type="text")
     */
    private $textEn;


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
     * @return Text
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
     * Set textCa
     *
     * @param string $textCa
     * @return Text
     */
    public function setTextCa($textCa)
    {
        $this->textCa = $textCa;
    
        return $this;
    }

    /**
     * Get textCa
     *
     * @return string 
     */
    public function getTextCa()
    {
        return $this->textCa;
    }

    /**
     * Set textEs
     *
     * @param string $textEs
     * @return Text
     */
    public function setTextEs($textEs)
    {
        $this->textEs = $textEs;
    
        return $this;
    }

    /**
     * Get textEs
     *
     * @return string 
     */
    public function getTextEs()
    {
        return $this->textEs;
    }

    /**
     * Set textEn
     *
     * @param string $textEn
     * @return Text
     */
    public function setTextEn($textEn)
    {
        $this->textEn = $textEn;
    
        return $this;
    }

    /**
     * Get textEn
     *
     * @return string 
     */
    public function getTextEn()
    {
        return $this->textEn;
    }
}
