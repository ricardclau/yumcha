<?php

namespace Yumcha\Bundle\WebsiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SpecialBubble
 *
 * @ORM\Table("special_bubbles", uniqueConstraints={@ORM\UniqueConstraint(columns={"name"})})
 * @ORM\Entity(repositoryClass="Yumcha\Bundle\WebsiteBundle\Entity\SpecialBubbleRepository")
 * @ORM\HasLifecycleCallbacks
 */
class SpecialBubble
{
    use EntityFilesTrait;

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
     * @ORM\Column(name="text_ca", type="text")
     * @Assert\NotBlank()
     */
    private $textCa;

    /**
     * @var string
     *
     * @ORM\Column(name="text_es", type="text")
     * @Assert\NotBlank()
     */
    private $textEs;

    /**
     * @var string
     *
     * @ORM\Column(name="text_en", type="text")
     * @Assert\NotBlank()
     */
    private $textEn;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=255)
     */
    private $photo;

    /**
     * @var string $file
     *
     * @Assert\Image()
     */
    private $file;

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
     * @return SpecialBubble
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
     * @return SpecialBubble
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
     * @return SpecialBubble
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
     * @return SpecialBubble
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

    /**
     * Set photo
     *
     * @param string $photo
     * @return SpecialBubble
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    
        return $this;
    }

    /**
     * Get photo
     *
     * @return string 
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param string $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }


    /**
     * @Assert\True(message="Foto needs to be uploaded")
     */
    public function isPhotoUploaded()
    {
        return !empty($this->file);
    }

    public function getUploadDir()
    {
        return $this->getUploadPath() . 'special_bubbles/';
    }

    public function getEntityFiles()
    {
        return array(
            array(
                'field_property' => 'file',
                'path_property' => 'photo',
                'thumbnails' => array(),
            ),
        );
    }
}
