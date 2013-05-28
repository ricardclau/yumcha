<?php

namespace Yumcha\Bundle\WebsiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SpecialIcecream
 *
 * @ORM\Table("special_icecreams", uniqueConstraints={@ORM\UniqueConstraint(columns={"name"})})
 * @ORM\Entity(repositoryClass="Yumcha\Bundle\WebsiteBundle\Entity\SpecialIcecreamRepository")
 * @ORM\HasLifecycleCallbacks
 */
class SpecialIcecream
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
     * @return SpecialIcecream
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
     * @return SpecialIcecream
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
     * @return SpecialIcecream
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
     * @return SpecialIcecream
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
     * Set photo
     *
     * @param string $photo
     * @return SpecialIcecream
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

    public function getUploadDir()
    {
        return $this->getUploadPath() . 'special_icecreams/';
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
