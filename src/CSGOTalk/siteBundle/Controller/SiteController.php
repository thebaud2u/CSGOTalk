<?php

namespace CSGOTalk\siteBundle\Controller;

use CSGOTalk\siteBundle\Entity\Thread;
use CSGOTalk\siteBundle\Entity\User;
use CSGOTalk\siteBundle\Entity\Image;
use CSGOTalk\siteBundle\Entity\Matchs;
use CSGOTalk\siteBundle\Entity\Team;

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
        $userInfoArray = self::menu($request);

        $match = new Matchs();
        $form = $this->get('form.factory')->create(new MatchsType(), $match);

        $formArray = array();
        $formArray['form'] = $form->createView();
        $array = array_merge($userInfoArray, $formArray);
        
        return $this->render('CSGOTalksiteBundle:Site:threads.html.twig', $array);
    }

/*      $teamName = array();
        $players = array();

        // On récupère les joueurs de l'équipe (pour le moment la seule équipe, plus tard, recherche par id d'équipe ou même du nom de l'équipe)
        $team = $this->getDoctrine()->getManager()->getRepository('CSGOTalksiteBundle:TeamPlayer')->getTeam();

        // On récupère le nom de l'équipe et on la stock dans un tableau associatif
        $team_1_Name = $team[0]->getTeam()->getName();
        $teamName['teamName'] = $team_1_Name;

        // On va parcourir les joueurs de l'équipe et les stocker dans un tableau associatif (player_id => pplayer_name)
        for($i = 0; $i<5 ; $i++){
            $players['Player'][$i] = $team[$i]->getPlayer()->getName();
        }

        // On récupère les infos de l'utilisateur pour l'affichage du header
        $userInfoArray = self::menu($request);

        // On merge tout les tableaux qu'on a pour les envoyers aux vues
        // On a besoin de tableau associatifs pour pouvoir différencier ce qu'on envoi à la vue
        // et ainsi afficher ce qu'on veut là où on le veut.
        $array = array_merge($userInfoArray, $teamName, $players);

        return $this->render('CSGOTalksiteBundle:Site:threads.html.twig', $array);
*/
}