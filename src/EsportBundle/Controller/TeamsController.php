<?php

namespace EsportBundle\Controller;

use EsportBundle\Entity\Team;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EsportBundle\Interfaces\PreController;


class TeamsController extends Controller implements PreController
{
    public function indexAction()
    {
        $session = $this->get('session');
        $game = $this->getDoctrine()->getRepository('EsportBundle:Game')->find($session->get('game')->getId());
        return $this->render('EsportBundle:Dashboard:teams.html.twig',array('teams'=>$game->getTeams()));
    }

    public function pageAction($id)
    {
        $team = $this->getDoctrine()->getRepository('EsportBundle:Team')->find($id);
        $showJoinButton = true;
        if($team->getPlayers()->contains($this->get('security.context')->getToken()->getUser())){
            $showJoinButton = false;
        }
        return $this->render('EsportBundle:Dashboard:team.html.twig',array('team'=>$team, "showButton"=>$showJoinButton));
    }

}
