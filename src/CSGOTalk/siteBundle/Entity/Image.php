<?php

namespace CSGOTalk\siteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Image
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="CSGOTalk\siteBundle\Entity\ImageRepository")
 */
class Image
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
     * @ORM\Column(name="url_small", type="string", length=255)
     */
    private $urlSmall;

    /**
     * @var string
     *
     * @ORM\Column(name="url_medium", type="string", length=255)
     */
    private $urlMedium;

    /**
     * @var string
     *
     * @ORM\Column(name="url_large", type="string", length=255)
     */
    private $urlLarge;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;


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
     * Set urlSmall
     *
     * @param string $urlSmall
     *
     * @return Image
     */
    public function setUrlSmall($urlSmall)
    {
        $this->urlSmall = $urlSmall;

        return $this;
    }

    /**
     * Get urlSmall
     *
     * @return string
     */
    public function getUrlSmall()
    {
        return $this->urlSmall;
    }

    /**
     * Set urlMedium
     *
     * @param string $urlMedium
     *
     * @return Image
     */
    public function setUrlMedium($urlMedium)
    {
        $this->urlMedium = $urlMedium;

        return $this;
    }

    /**
     * Get urlMedium
     *
     * @return string
     */
    public function getUrlMedium()
    {
        return $this->urlMedium;
    }

    /**
     * Set urlLarge
     *
     * @param string $urlLarge
     *
     * @return Image
     */
    public function setUrlLarge($urlLarge)
    {
        $this->urlLarge = $urlLarge;

        return $this;
    }

    /**
     * Get urlLarge
     *
     * @return string
     */
    public function getUrlLarge()
    {
        return $this->urlLarge;
    }

    /**
     * Set alt
     *
     * @param string $alt
     *
     * @return Image
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }
}

