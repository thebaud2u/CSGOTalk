<?php

namespace CSGOTalk\siteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="CSGOTalk\siteBundle\Entity\UserRepository")
 */
class User
{
    /**
     * @ORM\OneToOne(targetEntity="CSGOTalk\siteBundle\Entity\Image", cascade={"persist", "remove"})
     */
    private $image;

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
     * @ORM\Column(name="steam_id", type="string", length=255)
     */
    private $steamId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="CSGOTalk\siteBundle\Entity\Message", mappedBy="user")
     **/
    private $message;

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
     * Set steamId
     *
     * @param integer $steamId
     *
     * @return User
     */
    public function setSteamId($steamId)
    {
        $this->steamId = $steamId;

        return $this;
    }

    /**
     * Get steamId
     *
     * @return integer
     */
    public function getSteamId()
    {
        return $this->steamId;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return User
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
     * @param \CSGOTalk\siteBundle\Entity\Image $image
     *
     * @return User
     */
    public function setImage(\CSGOTalk\siteBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \CSGOTalk\siteBundle\Entity\Image
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
        $this->message = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add message
     *
     * @param \CSGOTalk\siteBundle\Entity\Message $message
     *
     * @return User
     */
    public function addMessage(\CSGOTalk\siteBundle\Entity\Message $message)
    {
        $this->message[] = $message;
    
        return $this;
    }

    /**
     * Remove message
     *
     * @param \CSGOTalk\siteBundle\Entity\Message $message
     */
    public function removeMessage(\CSGOTalk\siteBundle\Entity\Message $message)
    {
        $this->message->removeElement($message);
    }

    /**
     * Get message
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMessage()
    {
        return $this->message;
    }
}
