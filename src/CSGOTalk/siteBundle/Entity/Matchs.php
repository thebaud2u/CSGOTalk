<?php

namespace CSGOTalk\siteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Matchs
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="CSGOTalk\siteBundle\Entity\MatchsRepository")
 */
class Matchs
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
     * @ORM\OneToOne(targetEntity="CSGOTalk\siteBundle\Entity\Team", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $teamId1;

    /**
     * @ORM\OneToOne(targetEntity="CSGOTalk\siteBundle\Entity\Team", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $teamId2;

    /**
     * @ORM\OneToOne(targetEntity="CSGOTalk\siteBundle\Entity\BestOf", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $bestOfId;

    /**
     * @var string
     *
     * @ORM\Column(name="map", type="text")
     */
    private $map;


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
     * Set teamId1
     *
     * @param integer $teamId1
     *
     * @return Matchs
     */
    public function setTeamId1($teamId1)
    {
        $this->teamId1 = $teamId1;
    
        return $this;
    }

    /**
     * Get teamId1
     *
     * @return integer
     */
    public function getTeamId1()
    {
        return $this->teamId1;
    }

    /**
     * Set teamId2
     *
     * @param integer $teamId2
     *
     * @return Matchs
     */
    public function setTeamId2($teamId2)
    {
        $this->teamId2 = $teamId2;
    
        return $this;
    }

    /**
     * Get teamId2
     *
     * @return integer
     */
    public function getTeamId2()
    {
        return $this->teamId2;
    }

    /**
     * Set bestOfId
     *
     * @param integer $bestOfId
     *
     * @return Matchs
     */
    public function setBestOfId($bestOfId)
    {
        $this->bestOfId = $bestOfId;
    
        return $this;
    }

    /**
     * Get bestOfId
     *
     * @return integer
     */
    public function getBestOfId()
    {
        return $this->bestOfId;
    }

    /**
     * Set map
     *
     * @param string $map
     *
     * @return Matchs
     */
    public function setMap($map)
    {
        $this->map = $map;
    
        return $this;
    }

    /**
     * Get map
     *
     * @return string
     */
    public function getMap()
    {
        return $this->map;
    }
}
