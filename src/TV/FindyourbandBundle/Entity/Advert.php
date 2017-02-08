<?php

namespace TV\FindyourbandBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Advert
 *
 * @ORM\Table(name="advert")
 * @ORM\Entity(repositoryClass="TV\FindyourbandBundle\Repository\AdvertRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Advert
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;
    
    /**
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="TV\UserBundle\Entity\User", inversedBy="adverts", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="string", length=1000, nullable=true)
     * @Assert\NotBlank()
     * @Assert\Length(min=20, minMessage="Le contenu de l'annonce doit faire au moins {{ limit }} caractères.")
     * @Assert\Length(max=1000, maxMessage="Le contenu de l'annonce doit faire moins de {{ limit }} caractères.")
     */
    private $content;
    
    /**
     * @ORM\ManyToOne(targetEntity="TV\FindyourbandBundle\Entity\Province", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull
     */
    private $province;
    
    /**
     * @ORM\ManyToOne(targetEntity="TV\FindyourbandBundle\Entity\Level", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull
     */
    private $level;
    
    /**
     * @ORM\ManyToOne(targetEntity="TV\FindyourbandBundle\Entity\Instrument", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull
     */
    private $instrument;
    
    /**
     * @ORM\ManyToOne(targetEntity="TV\FindyourbandBundle\Entity\Genre", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull
     */
    private $genre;

     
    public function __construct()
    {
        $this->date = new \Datetime();
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Advert
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
    
    /**
     * Set title
     *
     * @param string $title
     *
     * @return Advert
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
     * Set author
     *
     * @param string $author
     *
     * @return Advert
     */
    public function setAuthor($author)
    {
        $this->author = $author;
        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Advert
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
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
    
    /**
    * @Assert\Callback
    */
    public function isContentValid(ExecutionContextInterface $context)
    {
      $forbiddenWords = array('merde', 'enfoiré', 'putain', 'pute', 'enculé', 'foutre', 'salaud');

      if (preg_match('#'.implode('|', $forbiddenWords).'#i', $this->getContent())) {
        $context
          ->buildViolation('Contenu invalide car il contient une insulte.') 
          ->atPath('content')
          ->addViolation()
        ;
      }
    }
    
}
