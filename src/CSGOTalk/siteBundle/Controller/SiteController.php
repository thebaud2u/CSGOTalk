<?php

namespace CSGOTalk\siteBundle\Controller;

use CSGOTalk\siteBundle\Entity\Matchs;

use CSGOTalk\siteBundle\Form\MatchsType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SiteController extends Controller
{
    public function menu($request)
    {   
        $em = $this->getDoctrine()->getManager();
        // Initialisation de la session
        // 1° cherche si une session existe déjà
        // 2° génère les infos pour steam : boutton ou pseudo et avatar
        // 3° valide les infos pour steam
        $session = $request->getSession();
        $steamAuth = $this->get('steam_auth');
        $steamId = $steamAuth->validate();

        // Si le steamId est valide, on l'implémente en session
        // On va aller chercher les infos de l'utilisateur grâce à l'API Steam
        // Dans ces infos, on récupère le pseudo, l'avatar small et l'url de son profil Steam
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
        // On créé l'affichage avec les infos.
        else 
        {
            $steamId = $session->get('steamId');
            $jsonInfo = file_get_contents("http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=664556FD11D9A256BD39BCBDFE757F60&steamids=$steamId");
            $data = json_decode($jsonInfo, true);
            //var_dump($data['response']['players'][0]);

            $userName = $data['response']['players'][0]['personaname'];
            $userAvatar = $data['response']['players'][0]['avatar'];
            $userAvatarMedium = $data['response']['players'][0]['avatarmedium'];
            $userAvatarFull = $data['response']['players'][0]['avatarfull'];
            $userUrl = $data['response']['players'][0]['profileurl'];
            $userSteamId = $data['response']['players'][0]['steamid'];

            // On check ensuite si l'utilisateur existe en bdd ou non
            $userExist = $em->getRepository('CSGOTalksiteBundle:User')->findOneBy(array('steamId' => $userSteamId));

            if(empty($userExist))
            {
                $image = new Image;
                $image->setUrlSmall($userAvatar);
                $image->setUrlMedium($userAvatarMedium);
                $image->setUrlLarge($userAvatarFull);

                $user = new User;
                $user->setSteamId($userSteamId);
                $user->setName($userName);
                $user->setImage($image);

                $em->persist($image);
                $em->persist($user);
                $em->flush();
            }

            return array(
                'button' => null,
                'nickname' => $userName,
                'avatar' => $userAvatar,
                'userUrl' => $userUrl
            );
        }
    }

    public function indexAction(Request $request)
    {   
        $userInfoArray = self::menu($request);
        return $this->render('CSGOTalksiteBundle:Site:index.html.twig', $userInfoArray);
    }

    public function threadsAction(Request $request)
    {   
        $em = $this->getDoctrine()->getManager();
        $userInfoArray = self::menu($request);
        $matchInfoArray = array();

        $threads = $em->getRepository('CSGOTalksiteBundle:Thread')->findAll();

        for ($i = 0; $i < count($threads); $i++)
        {
            $matchId = $threads[$i]->getMatchId();

            $matchId = $em->getRepository('CSGOTalksiteBundle:Matchs')->find($matchId);
            $matchInfoArray['Info']['Match_'.$i]['MatchId'] = $matchId->getId();

            $team1Id = $matchId->getTeamId1();
            $team2Id = $matchId->getTeamId2();

            $teamPlayerTeam1 = $em->getRepository('CSGOTalksiteBundle:TeamPlayer')->getTeam($team1Id);
            $teamPlayerTeam2 = $em->getRepository('CSGOTalksiteBundle:TeamPlayer')->getTeam($team2Id);        

            $matchInfoArray['Info']['Match_'.$i]['Team_1'] = $teamPlayerTeam1[0]->getTeam()->getName();
            $matchInfoArray['Info']['Match_'.$i]['Team_2'] = $teamPlayerTeam2[0]->getTeam()->getName();

            $bestOfId = $matchId->getBestOfId();
            $bestOf = $em->getRepository('CSGOTalksiteBundle:BestOf')->find($bestOfId);
            $matchInfoArray['Info']['Match_'.$i]['BestOf'] = $bestOf->getNumber();

            $matchInfoArray['Info']['Match_'.$i]['Map'] = $matchId->getMap();
            
        }
        
        $array = array_merge($userInfoArray, $matchInfoArray);

        return $this->render('CSGOTalksiteBundle:Site:threads.html.twig', $array);
    }

    public function createThreadAction(Request $request)
    {
        $userInfoArray = self::menu($request);

        $match = new Matchs();
        $form = $this->get('form.factory')->create(new MatchsType(), $match);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $data = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($match);
            $em->flush();

            return $this->redirectToRoute('csgo_talksite_threads');
        }

        $formArray = array();
        $formArray['form'] = $form->createView();
        $array = array_merge($userInfoArray, $formArray);

        return $this->render('CSGOTalksiteBundle:Site:create_thread.html.twig', $array);   
    }

    public function threadAction(Request $request, $id)
    {   
        $em = $this->getDoctrine()->getManager();
        $userInfoArray = self::menu($request);
        $threadInfoArray = array();

        $thread = $em->getRepository('CSGOTalksiteBundle:Thread')->find($id);

        $matchId = $thread->getMatchId();

        $team1Id = $matchId->getTeamId1();
        $team2Id = $matchId->getTeamId2();

        $teamPlayerTeam1 = $em->getRepository('CSGOTalksiteBundle:TeamPlayer')->getTeam($team1Id);
        $teamPlayerTeam2 = $em->getRepository('CSGOTalksiteBundle:TeamPlayer')->getTeam($team2Id);        

        $threadInfoArray['Info']['Team_1'] = $teamPlayerTeam1[0]->getTeam()->getName();
        $threadInfoArray['Info']['Team_2'] = $teamPlayerTeam2[0]->getTeam()->getName();

        $bestOfId = $matchId->getBestOfId();
        $bestOf = $em->getRepository('CSGOTalksiteBundle:BestOf')->find($bestOfId);
        $threadInfoArray['Info']['BestOf'] = $bestOf->getNumber();

        $threadInfoArray['Info']['Map'] = $matchId->getMap();

        for ($i = 0; $i<5 ; $i++){
            $threadInfoArray['Info']['TeamPlayer1'][$i] = $teamPlayerTeam1[$i]->getPlayer()->getName();
            $threadInfoArray['Info']['TeamPlayer2'][$i] = $teamPlayerTeam2[$i]->getPlayer()->getName();
        }

        $array = array_merge($userInfoArray, $threadInfoArray);

        return $this->render('CSGOTalksiteBundle:Site:thread.html.twig', $array);
    }
}