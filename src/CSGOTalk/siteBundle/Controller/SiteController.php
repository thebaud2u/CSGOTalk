<?php

namespace CSGOTalk\siteBundle\Controller;

use CSGOTalk\siteBundle\Entity\Thread;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SiteController extends Controller
{
    public function indexAction()
    {
    	$steamAuth = $this->get('steam_auth')->genUrl();

        return $this->render('CSGOTalksiteBundle:Site:index.html.twig', array(
        	'button' => $steamAuth)
        );
    }

    public function threadsAction()
    {
    	$threads = $this->getDoctrine()->getManager()->getRepository('CSGOTalksiteBundle:Thread')->getThreads();
        return $this->render('CSGOTalksiteBundle:Site:threads.html.twig', array(
        	'threads' => $threads)
        );
    }
}