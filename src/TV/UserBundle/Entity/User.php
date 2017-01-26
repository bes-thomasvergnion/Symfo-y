<?php

namespace TV\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="TV\UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="TV\UserBundle\Entity\Image", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     * @Assert\Valid()
     */
    private $image;
    
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
     * @ORM\OneToMany(targetEntity="TV\FindyourbandBundle\Entity\Advert", mappedBy="author", cascade={"remove"})
     */
    private $adverts;
    
    /**
     * @ORM\OneToMany(targetEntity="TV\UserBundle\Entity\Invitation", mappedBy="receiver")
     */
    private $invitations;

    /**
     * @ORM\Column(name="content", type="text", nullable=true)
     * @Assert\Length(min=20, minMessage="La decription doit faire au moins {{ limit }} caractères.")
     * @Assert\Length(max=1000, maxMessage="La decription de l'annonce doit faire moins de {{ limit }} caractères.")
     */
    protected $content;
    
    /**
     * @ORM\Column(name="video", type="string", length=255, nullable=true)
     */
    private $video;
    
    /**
     * @ORM\ManyToMany(targetEntity="TV\UserBundle\Entity\Band", cascade={"persist"}, inversedBy="users")
    */
    private $bands;

    /**
     * Set province
     *
     * @param string $province
     *
     * @return User
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
     * @return User
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
     * @return User
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
     * @return User
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
     * @return User
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
    
    public function __construct()
    {
      $this->adverts = new ArrayCollection();
      $this->bands = new ArrayCollection();
      $this->invitations = new ArrayCollection();
    }

    public function addAdvert(\TV\FindyourbandBundle\Entity\Advert $advert)
    {
      $this->adverts[] = $advert;
      $advert->setAuthor($this);
      return $this;
    }

    public function removeAdvert(\TV\FindyourbandBundle\Entity\Advert $advert)
    {
      $this->adverts->removeElement($advert);
    }

    public function getAdverts()
    {
      return $this->adverts;
    }
    
    public function setContent($content)
    {
      $this->content = $content;
    }
    public function getContent()
    {
      return $this->content;
    }

    public function setVideo($video)
    {
        $this->video = $video;

        return $this;
    }

    public function getVideo()
    {
        return $this->video;
    }

    /**
     * Add invitation
     *
     * @param \TV\UserBundle\Entity\Invitation $invitation
     *
     * @return User
     */
    public function addInvitation(\TV\UserBundle\Entity\Invitation $invitation)
    {
        $this->invitations[] = $invitation;
        $invitation->setReceiver($this);
        return $this;
    }

    /**
     * Remove invitation
     *
     * @param \TV\UserBundle\Entity\Invitation $invitation
     */
    public function removeInvitation(\TV\UserBundle\Entity\Invitation $invitation)
    {
        $this->invitations->removeElement($invitation);
        $invitation->setReceiver(null);
    }

    /**
     * Get invitations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInvitations()
    {
        return $this->invitations;
    }

    /**
     * Add band
     *
     * @param \TV\UserBundle\Entity\Band $band
     *
     * @return User
     */
    public function addBand(\TV\UserBundle\Entity\Band $band)
    {
        $this->bands[] = $band;

        return $this;
    }

    /**
     * Remove band
     *
     * @param \TV\UserBundle\Entity\Band $band
     */
    public function removeBand(\TV\UserBundle\Entity\Band $band)
    {
        $this->bands->removeElement($band);
    }

    /**
     * Get bands
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBands()
    {
        return $this->bands;
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
