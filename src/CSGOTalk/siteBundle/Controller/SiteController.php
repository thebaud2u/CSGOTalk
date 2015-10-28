<?php

namespace CSGOTalk\siteBundle\Controller;

use CSGOTalk\siteBundle\Entity\Thread;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SiteController extends Controller
{
    public function menu($request)
    {
        // Initialisation de la session
        // 1° cherche si une session existe déjà
        // 2° génère les infos pour steam : boutton ou pseudo et avatar
        // 3° valide les infos pour steam
        $session = $request->getSession();
        $steamAuth = $this->get('steam_auth');
        $steamId = $steamAuth->validate();

        // Si le steamId est valide, on l'implémente en session
        if ($steamId) {
            $session->set('steamId', $steamId);
        }

        // Si le steamId n'est pas valide, il n'est pas en session, donc on doit connecter l'utilisateur
        // On génère donc le boutton de connexion à steam avec redirection vers Home
        if(!$session->get('steamId'))
        {
            $steamApiKey = '664556FD11D9A256BD39BCBDFE757F60';
            $authUrl = $steamAuth->genUrl('http://localhost:8080/Symfony/web/app_dev.php/home', false);

            return array(
                'button' => $authUrl,
                'nickname' => null,
                'avatar' => null,
                'userUrl' => null
            );
        }
        // Le steamId est valide, il existe donc en session
        // On le récupère pour aller chercher les infos de l'utilisateur grâce à l'API Steam
        // Dans ces infos, on récupère le pseudo, l'avatar small et l'url de son profil Steam
        // On créé l'affichage avec ces infos.
        else 
        {
            $steamId = $session->get('steamId');
            $jsonInfo = file_get_contents("http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=664556FD11D9A256BD39BCBDFE757F60&steamids=$steamId");
            $data = json_decode($jsonInfo, true);
            //var_dump($data['response']['players'][0]);

            return array(
                'button' => null,
                'nickname' => $data['response']['players'][0]['personaname'],
                'avatar' => $data['response']['players'][0]['avatar'],
                'userUrl' => $data['response']['players'][0]['profileurl']
            );
        }
    }

    public function indexAction(Request $request)
    {   
        $array = self::menu($request);
        return $this->render('CSGOTalksiteBundle:Site:index.html.twig', $array);
    }

    public function threadsAction(Request $request)
    {
    	//$threads = $this->getDoctrine()->getManager()->getRepository('CSGOTalksiteBundle:Thread')->getThreads();
        $array = self::menu($request);
        return $this->render('CSGOTalksiteBundle:Site:threads.html.twig', $array);
    }
}