<?php
namespace CSGOTalk\siteBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * Team
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="CSGOTalk\siteBundle\Entity\TeamRepository")
 */
class Team
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
     * @ORM\Column(name="Name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="CSGOTalk\siteBundle\Entity\Matchs", mappedBy="teamId1")
     */
    private $matchTeamId1;

    /**
     * @ORM\OneToMany(targetEntity="CSGOTalk\siteBundle\Entity\Matchs", mappedBy="teamId2")
     */
    private $matchTeamId2;

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
     * Set name
     *
     * @param string $name
     *
     * @return Team
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
     * Constructor
     */
    public function __construct()
    {
        $this->matchTeamId1 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->matchTeamId2 = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add matchTeamId1
     *
     * @param \CSGOTalk\siteBundle\Entity\Matchs $matchTeamId1
     *
     * @return Team
     */
    public function addMatchTeamId1(\CSGOTalk\siteBundle\Entity\Matchs $matchTeamId1)
    {
        $this->matchTeamId1[] = $matchTeamId1;
    
        return $this;
    }

    /**
     * Remove matchTeamId1
     *
     * @param \CSGOTalk\siteBundle\Entity\Matchs $matchTeamId1
     */
    public function removeMatchTeamId1(\CSGOTalk\siteBundle\Entity\Matchs $matchTeamId1)
    {
        $this->matchTeamId1->removeElement($matchTeamId1);
    }

    /**
     * Get matchTeamId1
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMatchTeamId1()
    {
        return $this->matchTeamId1;
    }

    /**
     * Add matchTeamId2
     *
     * @param \CSGOTalk\siteBundle\Entity\Matchs $matchTeamId2
     *
     * @return Team
     */
    public function addMatchTeamId2(\CSGOTalk\siteBundle\Entity\Matchs $matchTeamId2)
    {
        $this->matchTeamId2[] = $matchTeamId2;
    
        return $this;
    }

    /**
     * Remove matchTeamId2
     *
     * @param \CSGOTalk\siteBundle\Entity\Matchs $matchTeamId2
     */
    public function removeMatchTeamId2(\CSGOTalk\siteBundle\Entity\Matchs $matchTeamId2)
    {
        $this->matchTeamId2->removeElement($matchTeamId2);
    }

    /**
     * Get matchTeamId2
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMatchTeamId2()
    {
        return $this->matchTeamId2;
    }
}
