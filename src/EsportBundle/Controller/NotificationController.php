<?php

namespace EsportBundle\Controller;

use EsportBundle\Entity\Notification;
use EsportBundle\Entity\NotificationInfos;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\Criteria;

class NotificationController extends Controller
{

    public function viewAction(){
        $repo = $this->getDoctrine()->getRepository('EsportBundle:Notification');
        $query = $repo->createQueryBuilder('u')
            ->join('u.recipients', 'r')
            ->where('r.player = :id')
            ->setParameter('id',$this->get('security.context')->getToken()->getUser()->getId())
            ->getQuery();

        return $this->render('EsportBundle:Notifications:center.html.twig',array("notifications"=>$query->getResult()));
    }

    public function sendInvitePlayerAction($id){
        $session = $this->get('session');
        $em = $this->getDoctrine()->getManager();
        $player = $this->getDoctrine()->getRepository('EsportBundle:Player')->find($id);

        $notification = new Notification();
        $notification->setType('Player');
        $notification->setSender($this->get('security.context')->getToken()->getUser());
        $notification->setSent(new \DateTime());
        $notification->setGame($session->get('game'));

        $infos = new NotificationInfos();
        $infos->setPlayer($player);
        $notification->addRecipient($infos);
        $em->persist($infos);
        $em->persist($notification);
        $em->flush();

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

        return $this->render('EsportBundle:Dashboard:player.html.twig',array(
                "player"   => $player,
                "teams"     => $queryPlayer->getResult(),
                "team"      => $queryUser->getResult()[0]
            ));
    }

    public function sendJoinTeamAction($id){
        $session = $this->get('session');
        $user = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $team = $this->getDoctrine()->getRepository('EsportBundle:Team')->find($id);
        $gameId = $team->getGame()->getId();

        $repo = $this->getDoctrine()->getRepository('EsportBundle:Team');
        $queryPlayer = $repo->createQueryBuilder('t')
            ->join('t.game', 'g')
            ->join('t.players','p')
            ->where('t.id = :id')
            ->andWhere('g.id = :idGame')
            ->andWhere('p.id = :idPlayer')
            ->setParameter('id',$id)
            ->setParameter('idGame',$gameId)
            ->setParameter('idPlayer',$user->getId())
            ->getQuery();
        $teams = $queryPlayer->getResult();
        if(empty($teams)){
            $notification = new Notification();
            $notification->setType('Team');
            $notification->setSender($user);
            $notification->setSent(new \DateTime());
            $notification->setGame($session->get('game'));
            foreach($team->getPlayers() as $player){
                $infos = new NotificationInfos();
                $infos->setPlayer($player);
                $notification->addRecipient($infos);
                $em->persist($infos);
            }
            $em->persist($notification);
            $em->flush();
            return $this->render('EsportBundle:Dashboard:team.html.twig',array('team'=>$team));
        }
        else{
            $serializer = $this->container->get('jms_serializer');
            $data = $serializer->serialize(array("error"=>true,"message"=>"You cannot subscribe in two teams for the same game."), "json");
            $response = new Response($data);
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }

    }

    public function acceptTeamJoinAction($id){

    }

    public function acceptPlayerJoinAction($id){
        $notification = $this->getDoctrine()->getRepository('EsportBundle:Notification')->find($id);
        $player = $this->get('security.context')->getToken()->getUser();

        $teams = $player->getTeams();

        foreach($teams as $team){
            if($team->getGame()->getId() == $notification->getGame()->getId()){
                $team->addPlayer($notification->getSender());
                $em = $this->getDoctrine()->getManager();
                $em->persist($team);
                try{
                    $em->flush();
                }
                catch(\Doctrine\DBAL\DBALException $e){
                    return (new Response(json_encode(array("error"=>true,"message"=>"This player is already in your team"))))->setStatusCode(400);
                }

            }
        }

        $serializer = $this->container->get('jms_serializer');
        $data = $serializer->serialize(array("error"=>false), "json");
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        return $response;


    }

    public function refuseTeamJoinAction($id){
        $em = $this->getDoctrine()->getManager();
        $notification = $this->getDoctrine()->getRepository('EsportBundle:Notification')->find($id);
        $serializer = $this->get('jms_serializer');
        $data = $serializer->serialize($notification, "json");
    }

    public function refusePlayerJoinAction($id){
        return new Response();
    }

    public function getNotificationAction($id){
        try{
            $em = $this->getDoctrine()->getManager();
            $notification = $this->getDoctrine()->getRepository('EsportBundle:Notification')->find($id);
            $recipients = $notification->getRecipients();

            foreach($recipients as $recipient){
                if($recipient->getPlayer()->getId() == $this->get('security.context')->getToken()->getUser()->getId()){
                    $recipient->setIsRead(true);
                    $em->persist($recipient);
                    $em->flush();
                }
            }

            $sender = $notification->getSender();


            $serializer = $this->get('jms_serializer');

            $data = $serializer->serialize($notification, "json");
            $response = new Response($data);
            $response->headers->set("Content-Type","application/json");
            return $response;
        }
        catch(\Exception $e){
            return new Response(json_encode(array("error"=>$e->getMessage())));
        }

    }

    public function countAction(){
        $repo = $this->getDoctrine()->getRepository('EsportBundle:Notification');
        $query = $repo->createQueryBuilder('u')
            ->join('u.recipients', 'r')
            ->where('r.player = :id')
            ->andWhere('r.isRead = 0')
            ->setParameter('id',$this->get('security.context')->getToken()->getUser()->getId())
            ->getQuery();
        return new Response(count($query->getResult()));
    }
}
