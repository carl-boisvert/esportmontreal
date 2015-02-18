<?php

namespace EsportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EsportBundle\Interfaces\PreController;

class PlayerController extends Controller implements PreController
{
    public function indexAction()
    {
        $player = $this->get('security.context')->getToken()->getUser();
        $repository = $this->getDoctrine()->getRepository('EsportBundle:Player');
        $consoles = $player->getConsoles()->map(function($entity){return $entity->getName();})->toArray();
        $query = $repository->createQueryBuilder('p')
            ->leftJoin('p.consoles','c')
            ->where("c.name IN(:consoles)")
            ->setParameter('consoles', $consoles)
            ->getQuery();
        $players = $query->getResult();
        return $this->render('EsportBundle:Dashboard:players.html.twig', array(
                "players"   => $players
            ));
    }

    public function pageAction($id){
        $player = $this->getDoctrine()->getRepository('EsportBundle:Player')->find($id);
        $repo = $this->getDoctrine()->getRepository('EsportBundle:Team');
        $queryPlayer = $repo->createQueryBuilder('u')
            ->join('u.players', 'r')
            ->where('r.id = :id')
            ->setParameter('id',$player->getId())
             ->getQuery();
        // Get current user team
        $queryUser = $repo->createQueryBuilder('u')
            ->join('u.players', 'r')
            ->where('r.id = :id')
            ->setParameter('id',$this->get('security.context')->getToken()->getUser()->getId())
            ->getQuery();
        $team = null;
        $showInviteButton = true;
        if($queryUser->getResult()){
            $team = $queryUser->getResult()[0];
            if($player->getTeams()->contains($team)){
                $showInviteButton = false;
            }
        }

        return $this->render('EsportBundle:Dashboard:player.html.twig', array(
                "player"   => $player,
                "teams"     => $queryPlayer->getResult(),
                "team"      => $team,
                "showButton"=> $showInviteButton
            ));
    }
}
