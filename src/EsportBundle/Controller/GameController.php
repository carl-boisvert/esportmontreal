<?php

namespace EsportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class GameController extends Controller
{

    public function indexAction(Request $request)
    {

        $games = $this->getDoctrine()->getRepository('EsportBundle:Game')->findAll();
        $player = $this->get('security.context')->getToken()->getUser();
        $playersGames = $player->getGames()->toArray();
        $playersConsoles = $player->getConsoles()->map(function($entity){ return $entity->getName();})->toArray();

        $usersGames = array();
        $usersConsoles = array();
        foreach($playersConsoles as $key=>$value){
            $usersConsoles[] = $value;
        }
        foreach($playersGames as $playerGame){
            $game = $playerGame->getGame();
            $usersGames[$game->getId()] = $playerGame->getConsole()->getId();
        }

        return $this->render('EsportBundle:Dashboard:games.html.twig', array(
                "games"   => $games,
                "playersGames" => $usersGames,
                "playersConsoles" => $usersConsoles,
                "noGame" => $request->query->get('noGame')
            ));
    }

    public function setGameAction($gameId,$consoleId){
        $game = $this->getDoctrine()->getRepository('EsportBundle:Game')->find($gameId);
        $console = $this->getDoctrine()->getRepository('EsportBundle:Console')->find($consoleId);
        $playerGames = $this->getDoctrine()->getRepository('EsportBundle:PlayersGames')->findBy(array("game"=>$game,"console"=>$console,"player"=>$this->get('security.context')->getToken()->getUser()));

        $session = $this->get('session');
        $session->set('game',$game);
        $session->set('console',$console);
        return $this->redirect($this->generateUrl('esport_homepage'));
    }
}
