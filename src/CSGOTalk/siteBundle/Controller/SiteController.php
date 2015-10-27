<?php

namespace CSGOTalk\siteBundle\Controller;

use CSGOTalk\siteBundle\Entity\Thread;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SiteController extends Controller
{
    public function indexAction(Request $request)
    {
        if($request == null)
        {
            $steamApiKey = '664556FD11D9A256BD39BCBDFE757F60';
            $steamAuth = $this->get('steam_auth');
            $authUrl = $steamAuth->genUrl('http://localhost:8080/Symfony/web/app_dev.php/home', false);

            return $this->render('CSGOTalksiteBundle:Site:index.html.twig', array(
                'button' => $authUrl,
                'nickname' => null,
                'avatar' => null)
            );
        }
        else 
        {
            $session = $request->getSession();

            $steamAuth = $this->get('steam_auth');
            $steamId = $steamAuth->validate();

            if ($steamId) {
                $session->set('steamId', $steamId);
            }

            // non connecté, redirection sur steam ou la page de connexion (plus tard)
            if (!$session->get('steamId')) {
                return $this->redirect($authUrl);
            }
            
            $steamId = $session->get('steamId');
            $jsonInfo = file_get_contents("http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=664556FD11D9A256BD39BCBDFE757F60&steamids=$steamId");
            $data = json_decode($jsonInfo, true);
            //var_dump($data['response']['players'][0]);
            //echo $data['response']['players'][0]['personaname'];
            //echo '<img src="'.$data['response']['players'][0]['avatar'].'">';

            return $this->render('CSGOTalksiteBundle:Site:index.html.twig', array(
                'button' => null,
                'nickname' => $data['response']['players'][0]['personaname'],
                'avatar' => $data['response']['players'][0]['avatar'])
            );
        }
    }

    public function threadsAction()
    {
    	$threads = $this->getDoctrine()->getManager()->getRepository('CSGOTalksiteBundle:Thread')->getThreads();
        return $this->render('CSGOTalksiteBundle:Site:threads.html.twig', array(
        	'threads' => $threads)
        );
    }
}