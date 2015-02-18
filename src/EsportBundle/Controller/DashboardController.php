<?php

namespace EsportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use EsportBundle\Interfaces\PreController;

class DashboardController extends Controller implements PreController
{

    public function indexAction()
    {
        //$session = $this->get('session');
        //$team = $this->get('security.context')->getToken()->getUser()->getTeams()[0];
        /*$session->remove('game');
        if(!$session->get('game') && $team){
            $session->set('game',$team->getGame());
        }*/
        $user= $this->get('security.context')->getToken()->getUser();
        return $this->render('EsportBundle:Dashboard:index.html.twig', array('user' => $user));
    }

    public function gameAction($id){
        $game = $this->getDoctrine()->getRepository("EsportBundle:Game")->find($id);
        /*$player = $this->getDoctrine()->getRepository("EsportBundle:Player")->find(4);
        $team = $this->getDoctrine()->getRepository("EsportBundle:Team")->find(4);
        $game->addTeam($team);
        $team->setGame($game);
        $team->addPlayer($player);
        $player->addTeam($team);
        $em = $this->getDoctrine()->getManager();
        $em->persist($game);
        $em->persist($team);
        $em->persist($player);
        $em->flush();
        exit;*/
        $serialiszer = $this->get('jms_serializer');
        $response = new Response($serialiszer->serialize($game,"json"));
        $response->headers->add(array("content-type"=>"application/json"));
        return $response;
    }
}
