<?php

namespace TV\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Band
 *
 * @ORM\Table(name="band")
 * @ORM\Entity(repositoryClass="TV\UserBundle\Repository\BandRepository")
 * @UniqueEntity(fields="name", message="Un groupe existe déjà avec ce nom.")
 */
class Band
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     * @Assert\Length(min=20, minMessage="La decription du groupe doit faire au moins {{ limit }} caractères.")
     * @Assert\Length(max=1000, maxMessage="La decription du groupe doit faire moins de {{ limit }} caractères.")
     */
    private $content;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="video", type="string", length=255, nullable=true)
     */
    private $video;
    
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
     * @ORM\ManyToOne(targetEntity="TV\FindyourbandBundle\Entity\Genre", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $genre;
    
    /**
     * @ORM\OneToOne(targetEntity="TV\UserBundle\Entity\Image", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     * @Assert\Valid()
     */
    private $image;
    
    /**
     * @ORM\ManyToMany(targetEntity="TV\UserBundle\Entity\User", mappedBy="bands")
    */
    private $users;
    
    /**
     * @ORM\ManyToOne(targetEntity="TV\UserBundle\Entity\User", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $administrator;


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
     * @return Band
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
     * Set content
     *
     * @param string $content
     *
     * @return Band
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Band
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
     * Set video
     *
     * @param string $video
     *
     * @return Band
     */
    public function setVideo($video)
    {
        $this->video = $video;

        return $this;
    }

    /**
     * Get video
     *
     * @return string
     */
    public function getVideo()
    {
        return $this->video;
    }
    
    /**
     * Set province
     *
     * @param string $province
     *
     * @return Band
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
     * Set level
     *
     * @param string $level
     *
     * @return Band
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
     * @return Band
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
     * Set image
     *
     * @param \TV\UserBundle\Entity\Image $image
     *
     * @return Band
     */
    public function setImage(Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \TV\UserBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->date = new \Datetime();
        $this->users = new ArrayCollection();
    }

    /**
     * Add user
     *
     * @param \TV\UserBundle\Entity\User $user
     *
     * @return Band
     */
    public function addUser(\TV\UserBundle\Entity\User $user)
    {
        $this->users[] = $user;
        $user->addBand($this);
        return $this;
    }

    /**
     * Remove user
     *
     * @param \TV\UserBundle\Entity\User $user
     */
    public function removeUser(\TV\UserBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }
    
    /**
     * Set administrator
     *
     * @param string $administrator
     *
     * @return Band
     */
    public function setAdministrator($administrator)
    {
        $this->administrator = $administrator;

        return $this;
    }

    /**
     * Get administrator
     *
     * @return string
     */
    public function getAdministrator()
    {
        return $this->administrator;
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
