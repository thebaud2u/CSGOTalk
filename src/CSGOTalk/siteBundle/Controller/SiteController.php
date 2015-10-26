<?php

namespace CSGOTalk\siteBundle\Controller;

use CSGOTalk\siteBundle\Entity\Thread;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SiteController extends Controller
{
    public function indexAction()
    {
        $steamApiKey = '664556FD11D9A256BD39BCBDFE757F60';
        $steamAuth = $this->get('steam_auth');
        $authUrl = $steamAuth->genUrl('http://localhost:8080/Symfony/app_dev.php/get', false);

        return $this->render('CSGOTalksiteBundle:Site:index.html.twig', array(
        	'button' => $authUrl)
        );
    }

    public function threadsAction()
    {
    	$threads = $this->getDoctrine()->getManager()->getRepository('CSGOTalksiteBundle:Thread')->getThreads();
        return $this->render('CSGOTalksiteBundle:Site:threads.html.twig', array(
        	'threads' => $threads)
        );
    }

    public function displayAction()
    {
        $session = $request->getSession();

        $steamId = $steamAuth->validate();

        if ($steamId) {
            $session->set('steamId', $steamId);
            dump($session->get('steamId'));
        }

        // non connecté, redirection sur steam ou la page de connexion (plus tard)
        if (!$session->get('steamId')) {
            return $this->redirect($authUrl);
        }
    }
}