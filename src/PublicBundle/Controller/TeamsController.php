<?php

namespace PublicBundle\Controller;

use EsportBundle\Entity\Team;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use EsportBundle\Entity\Player;
use EsportBundle\Form\TeamType;


class TeamsController extends Controller
{
    public function indexAction()
    {
        $teams = $this->getDoctrine()->getRepository('EsportBundle:Team')->findAll();
        return $this->render('PublicBundle:Home:teams.html.twig',array('teams'=>$teams));
    }

    public function teamAction(Request $request){
        $team = new Team();
        $player = new Player();
        $team->addPlayer($player);
        $form = $this->createForm(new TeamType($this->getDoctrine()->getManager(),$this->get('logger')),$team);
        $form->handleRequest($request);
        $team->setConsole($player->getConsole());

        if ($form->isValid()) {
            $team = $form->getData();
            $players = $team->getPlayers();
            $player = $players[0];
            $player->setHash(mt_rand());
            $player->setStatus('pending');

            $factory = $this->container->get('security.encoder_factory');
            $encoder = $factory->getEncoder($player);
            $pwd = $encoder->encodePassword($player->getPassword(), $player->getSalt());
            $player->setPassword($pwd);

            $em = $this->getDoctrine()->getManager();
            $em->persist($team);
            $em->persist($player);
            $em->flush();
        }

        return $this->render('PublicBundle:Home:subscribeTeam.html.twig',array('form'=>$form->createView()));
    }
}
