<?php

namespace CSGOTalk\siteBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * TeamPlayRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TeamPlayerRepository extends EntityRepository
{
	public function getTeam($id)
	{
	    $qb = $this->createQueryBuilder('TeamPlayer');
	    $qb
	      	->join('TeamPlayer.team', 'Team')
	      	->join('TeamPlayer.player', 'Player')
	      	->addSelect('Team')
	      	->addSelect('Player')
	      	->where('Team.id = :id')
    		->setParameter('id', $id)
	    ;
	    return $qb
	      	->getQuery()
	      	->getResult()
	    ;
	}}
