<?php

namespace CSGOTalk\siteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BestOf
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="CSGOTalk\siteBundle\Entity\BestOfRepository")
 */
class BestOf
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
     * @var integer
     *
     * @ORM\Column(name="number", type="integer")
     */
    private $number;


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
     * Set number
     *
     * @param integer $number
     *
     * @return BestOf
     */
    public function setNumber($number)
    {
        $this->number = $number;
    
        return $this;
    }

    /**
     * Get number
     *
     * @return integer
     */
    public function getNumber()
    {
        return $this->number;
    }
}

