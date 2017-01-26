<?php

namespace TV\FindyourbandBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Search
 *
 * @ORM\Table(name="search")
 * @ORM\Entity(repositoryClass="TV\FindyourbandBundle\Repository\SearchRepository")
 */
class Search
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
     * @ORM\ManyToOne(targetEntity="TV\FindyourbandBundle\Entity\Province", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $province;
    
    /**
     * @ORM\ManyToOne(targetEntity="TV\FindyourbandBundle\Entity\Level", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $level;
    
    /**
     * @ORM\ManyToOne(targetEntity="TV\FindyourbandBundle\Entity\Instrument", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $instrument;
    
    /**
     * @ORM\ManyToOne(targetEntity="TV\FindyourbandBundle\Entity\Genre", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $genre;
    
    
    
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
     * Set province
     *
     * @param string $province
     *
     * @return Advert
     */
    public function setProvince($province)
    {
        $this->province = $province;
        return $this;
    }

    /**
     * Get province
     *
     * @return string
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * Set instrument
     *
     * @param string $instrument
     *
     * @return Advert
     */
    public function setInstrument($instrument)
    {
        $this->instrument = $instrument;
        return $this;
    }

    /**
     * Get instrument
     *
     * @return string
     */
    public function getInstrument()
    {
        return $this->instrument;
    }

    /**
     * Set level
     *
     * @param string $level
     *
     * @return Advert
     */
    public function setLevel($level)
    {
        $this->level = $level;
        return $this;
    }

    /**
     * Get level
     *
     * @return string
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set genre
     *
     * @param \TV\FindyourbandBundle\Entity\Genre $genre
     *
     * @return Advert
     */
    public function setGenre(\TV\FindyourbandBundle\Entity\Genre $genre = null)
    {
        $this->genre = $genre;
        return $this;
    }

    /**
     * Get genre
     *
     * @return \TV\FindyourbandBundle\Entity\Genre
     */
    public function getGenre()
    {
        return $this->genre;
    }
}

