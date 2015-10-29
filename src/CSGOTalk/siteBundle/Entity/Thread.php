<?php

namespace CSGOTalk\siteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Thread
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="CSGOTalk\siteBundle\Entity\ThreadRepository")
 */
class Thread
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
     * @ORM\OneToOne(targetEntity="CSGOTalk\siteBundle\Entity\Matchs", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $match_id;


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
     * Set matchId
     *
     * @param \CSGOTalk\siteBundle\Entity\Matchs $matchId
     *
     * @return Thread
     */
    public function setMatchId(\CSGOTalk\siteBundle\Entity\Matchs $matchId)
    {
        $this->match_id = $matchId;
    
        return $this;
    }

    /**
     * Get matchId
     *
     * @return \CSGOTalk\siteBundle\Entity\Matchs
     */
    public function getMatchId()
    {
        return $this->match_id;
    }
}
