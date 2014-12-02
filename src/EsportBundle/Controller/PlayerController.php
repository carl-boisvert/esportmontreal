<?php

namespace EsportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PlayerController extends Controller
{
    public function indexAction()
    {
        $players = $this->getDoctrine()->getRepository('EsportBundle:Player')->findAll();
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
        $queryUser = $repo->createQueryBuilder('u')
            ->join('u.players', 'r')
            ->where('r.id = :id')
            ->setParameter('id',$this->get('security.context')->getToken()->getUser()->getId())
            ->getQuery();
        return $this->render('EsportBundle:Dashboard:player.html.twig', array(
                "player"   => $player,
                "teams"     => $queryPlayer->getResult(),
                "team"      => $queryUser->getResult()[0]
            ));
    }
}
