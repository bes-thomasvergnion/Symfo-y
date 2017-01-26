<?php

namespace TV\FindyourbandBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Instrument
 *
 * @ORM\Table(name="instrument")
 * @ORM\Entity(repositoryClass="TV\FindyourbandBundle\Repository\InstrumentRepository")
 */
class Instrument
{
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
     * @ORM\OneToOne(targetEntity="TV\FindyourbandBundle\Entity\ImageInstru", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $image_instru;


    public function __construct()
    {
        $this->advert = new ArrayCollection();
    }
    
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
     * @return Instrument
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
     * Set image
     *
     * @param \TV\FindyourbandBundle\Entity\Image $image_instru
     *
     * @return Advert
     */
    public function setImage_instru(\TV\FindyourbandBundle\Entity\ImageInstru $image_instru = null)
    {
        $this->image_instru = $image_instru;

        return $this;
    }

    /**
     * Get image
     *
     * @return \TV\FindyourbandBundle\Entity\ImageInstru
     */
    public function getImage_instru()
    {
        return $this->image_instru;
    }

    /**
     * Set imageInstru
     *
     * @param \TV\FindyourbandBundle\Entity\ImageInstru $imageInstru
     *
     * @return Instrument
     */
    public function setImageInstru(\TV\FindyourbandBundle\Entity\ImageInstru $imageInstru = null)
    {
        $this->image_instru = $imageInstru;

        return $this;
    }

    /**
     * Get imageInstru
     *
     * @return \TV\FindyourbandBundle\Entity\ImageInstru
     */
    public function getImageInstru()
    {
        return $this->image_instru;
    }
}
