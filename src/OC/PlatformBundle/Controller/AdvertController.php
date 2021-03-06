<?php

namespace OC\PlatformBundle\Controller;

use OC\PlatformBundle\Form\AdvertType;
use OC\PlatformBundle\Entity\Advert;
use OC\PlatformBundle\Entity\Image;
use OC\PlatformBundle\Entity\Application;
use OC\PlatformBundle\Entity\AdvertSkill;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdvertController extends Controller
{
	public function menuAction($limit = 3)
  	{
    	$listAdverts = $this->getDoctrine()->getManager()->getRepository('OCPlatformBundle:Advert')
      		->findBy(
	        	array(),                 // Pas de critère
	        	array('date' => 'desc'), // On trie par date décroissante
	        	$limit,                  // On sélectionne $limit annonces
	        	0                        // À partir du premier
    		);

    	return $this->render('OCPlatformBundle:Advert:menu.html.twig', array(
      		'listAdverts' => $listAdverts
    	));
  	}	

	public function indexAction($page)
	{
	    if ($page < 1) {
	      	// On déclenche une exception NotFoundHttpException, cela va afficher
	      	// une page d'erreur 404 (qu'on pourra personnaliser plus tard d'ailleurs)
	      	throw new NotFoundHttpException('Page "'.$page.'" inexistante.');
	    }

	    $nbPerPage = 3;

	    $listAdverts = $this->getDoctrine()->getManager()->getRepository('OCPlatformBundle:Advert')->getAdverts($page, $nbPerPage);

    	// On calcule le nombre total de pages grâce au count($listAdverts) qui retourne le nombre total d'annonces
    	$nbPages = ceil(count($listAdverts)/$nbPerPage);

    	// Si la page n'existe pas, on retourne une 404
    	if ($page > $nbPages) {
      		throw $this->createNotFoundException("La page ".$page." n'existe pas.");
    	}

    	// On donne toutes les informations nécessaires à la vue
    	return $this->render('OCPlatformBundle:Advert:index.html.twig', array(
      		'listAdverts' => $listAdverts,
      		'nbPages'     => $nbPages,
      		'page'        => $page
    	));
  	}

	public function viewAction($id)
	{
		$em = $this->getDoctrine()->getManager();

	    // On récupère l'annonce $id
	    $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);

	    if (null === $advert) {
	      	throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
	    }

	    // On récupère maintenant la liste des AdvertSkill
	    $listAdvertSkills = $em->getRepository('OCPlatformBundle:AdvertSkill')->findByAdvert($advert);

	    // On avait déjà récupéré la liste des candidatures
	    $listApplications = $em->getRepository('OCPlatformBundle:Application')->findBy(array('advert' => $advert));

	    return $this->render('OCPlatformBundle:Advert:view.html.twig', array(
	      	'advert'           => $advert,
	      	'listApplications' => $listApplications,
	      	'listAdvertSkills' => $listAdvertSkills
	    ));
	}

	  public function addAction(Request $request)
	  {
	    $advert = new Advert();
	    $form = $this->createForm(new AdvertType(), $advert);

	    if ($form->handleRequest($request)->isValid()) {
	      $em = $this->getDoctrine()->getManager();
	      $em->persist($advert);
	      $em->flush();

	      $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

	      return $this->redirect($this->generateUrl('oc_platform_view', array('id' => $advert->getId())));
	    }

	    // À ce stade :
	    // - Soit la requête est de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
	    // - Soit la requête est de type POST, mais le formulaire n'est pas valide, donc on l'affiche de nouveau
	    return $this->render('OCPlatformBundle:Advert:add.html.twig', array(
	      'form' => $form->createView(),
	    ));
	  }

	public function editAction($id, Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    // On récupère l'annonce $id
    $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);

    if (null === $advert) {
      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
    }

    $form = $this->createForm(new AdvertEditType(), $advert);

    if ($form->handleRequest($request)->isValid()) {
      // Inutile de persister ici, Doctrine connait déjà notre annonce
      $em->flush();

      $request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');

      return $this->redirect($this->generateUrl('oc_platform_view', array('id' => $advert->getId())));
    }

    return $this->render('OCPlatformBundle:Advert:edit.html.twig', array(
      'form'   => $form->createView(),
      'advert' => $advert // Je passe également l'annonce à la vue si jamais elle veut l'afficher
    ));
  }

	public function deleteAction($id, Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    // On récupère l'annonce $id
    $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);

    if (null === $advert) {
      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
    }

    // On crée un formulaire vide, qui ne contiendra que le champ CSRF
    // Cela permet de protéger la suppression d'annonce contre cette faille
    $form = $this->createFormBuilder()->getForm();

    if ($form->handleRequest($request)->isValid()) {
      $em->remove($advert);
      $em->flush();

      $request->getSession()->getFlashBag()->add('info', "L'annonce a bien été supprimée.");

      return $this->redirect($this->generateUrl('oc_platform_home'));
    }

    // Si la requête est en GET, on affiche une page de confirmation avant de supprimer
    return $this->render('OCPlatformBundle:Advert:delete.html.twig', array(
      'advert' => $advert,
      'form'   => $form->createView()
    ));
  }
}