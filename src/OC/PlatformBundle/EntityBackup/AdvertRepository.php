<?php

namespace OC\PlatformBundle\Entity;

/**
 * AdvertRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;

class AdvertRepository extends EntityRepository
{
	public function myFindAll()
	{
    	return $this
    	->createQueryBuilder('a')
    	->getQuery()
    	->getResult()
  		;
	}

  public function getAdverts($page, $nbPerPage)
  {
    $query = $this->createQueryBuilder('a')
      ->leftJoin('a.image', 'i')->addSelect('i')
      ->leftJoin('a.categories','c')->addSelect('c')
      ->orderBy('a.date', 'DESC')
      ->getQuery()
    ;

    $query
      // On définit l'annonce à partir de laquelle commencer la liste
      ->setFirstResult(($page-1) * $nbPerPage)
      // Ainsi que le nombre d'annonce à afficher sur une page
      ->setMaxResults($nbPerPage)
    ;

    // Enfin, on retourne l'objet Paginator correspondant à la requête construite
    return new Paginator($query, true);
  }

	public function whereCurrentYear(QueryBuilder $qb)
  	{
    	$qb
      		->andWhere('a.date BETWEEN :start AND :end')
      		->setParameter('start', new \Datetime(date('Y').'-01-01'))  // Date entre le 1er janvier de cette année
      		->setParameter('end',   new \Datetime(date('Y').'-12-31'))  // Et le 31 décembre de cette année
    	;
  	}

  	/**
	 * récupérer toutes les annonces qui correspondent à une liste de catégories. 
	 * Par exemple, on veut toutes les annonces dans les catégories Développeur et Intégrateur
	 */
  	public function getAdvertWithCategories(array $categoryNames)
  	{
    	$qb = $this->createQueryBuilder('a');

    	// On fait une jointure avec l'entité Category avec pour alias « c »
    	$qb
      		->join('a.categories', 'c')
      		->addSelect('c')
    	;

    // Puis on filtre sur le nom des catégories à l'aide d'un IN
    	$qb->where($qb->expr()->in('c.name', $categoryNames));
    // La syntaxe du IN et d'autres expressions se trouve dans la documentation Doctrine

    // Enfin, on retourne le résultat
    	return $qb
      		->getQuery()
      		->getResult()
    	;
  }

  	/**
	 * récupérer les X dernières candidatures avec leur annonce associée
	 */
	public function getApplicationsWithAdvert($limit)
  {
    $qb = $this->createQueryBuilder('a');

    // On fait une jointure avec l'entité Advert avec pour alias « adv »
    $qb
      ->join('a.advert', 'adv')
      ->addSelect('adv')
    ;

    // Puis on ne retourne que $limit résultats
    $qb->setMaxResults($limit);

    // Enfin, on retourne le résultat
    return $qb
      ->getQuery()
      ->getResult()
    ;
  }

}