<?php

namespace CSGOTalk\siteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TeamPlayer
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="CSGOTalk\siteBundle\Entity\TeamPlayerRepository")
 */
class TeamPlayer
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
     * @ORM\ManyToOne(targetEntity="CSGOTalk\siteBundle\Entity\Team")
     * @ORM\JoinColumn(nullable=false)
     */
    private $team;

    /**
     * @ORM\ManyToOne(targetEntity="CSGOTalk\siteBundle\Entity\Player")
     * @ORM\JoinColumn(nullable=false)
     */
    private $player;


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
     * Set team
     *
     * @param \CSGOTalk\siteBundle\Entity\Team $team
     *
     * @return TeamPlayer
     */
    public function setTeam(\CSGOTalk\siteBundle\Entity\Team $team)
    {
        $this->team = $team;
    
        return $this;
    }

    /**
     * Get team
     *
     * @return \CSGOTalk\siteBundle\Entity\Team
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * Set player
     *
     * @param \CSGOTalk\siteBundle\Entity\Player $player
     *
     * @return TeamPlayer
     */
    public function setPlayer(\CSGOTalk\siteBundle\Entity\Player $player)
    {
        $this->player = $player;
    
        return $this;
    }

    /**
     * Get player
     *
     * @return \CSGOTalk\siteBundle\Entity\Player
     */
    public function getPlayer()
    {
        return $this->player;
    }
}
