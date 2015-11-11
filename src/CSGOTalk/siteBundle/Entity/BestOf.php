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
     * @var string
     *
     * @ORM\Column(name="number", type="string", length=255)
     */
    private $number;

    /**
     * @ORM\OneToMany(targetEntity="CSGOTalk\siteBundle\Entity\Matchs", mappedBy="bestOfId")
     */
    private $matchBestOf;

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
     * @param string $number
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
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->matchBestOf = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add matchBestOf
     *
     * @param \CSGOTalk\siteBundle\Entity\Matchs $matchBestOf
     *
     * @return BestOf
     */
    public function addMatchBestOf(\CSGOTalk\siteBundle\Entity\Matchs $matchBestOf)
    {
        $this->matchBestOf[] = $matchBestOf;
    
        return $this;
    }

    /**
     * Remove matchBestOf
     *
     * @param \CSGOTalk\siteBundle\Entity\Matchs $matchBestOf
     */
    public function removeMatchBestOf(\CSGOTalk\siteBundle\Entity\Matchs $matchBestOf)
    {
        $this->matchBestOf->removeElement($matchBestOf);
    }

    /**
     * Get matchBestOf
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMatchBestOf()
    {
        return $this->matchBestOf;
    }
}
