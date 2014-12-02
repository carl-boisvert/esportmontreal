<?php

namespace EsportBundle\Controller;

use EsportBundle\Entity\Team;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class TeamsController extends Controller
{
    public function indexAction()
    {
        $game = $this->getDoctrine()->getRepository('EsportBundle:Game')->find(1);
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
