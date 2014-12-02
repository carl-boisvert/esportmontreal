<?php

namespace PublicBundle\Controller;

use EsportBundle\Entity\Player;
use EsportBundle\Form\PlayerType;
use PublicBundle\Form\LoginType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;

class PlayersController extends Controller
{

    public function playerAction(Request $request){
        $form = $this->createForm(new PlayerType($this->getDoctrine()->getManager(),$this->get('logger')),new Player());
        $form->handleRequest($request);
        if ($form->isValid()) {
            $player = $form->getData();
            $player->setHash(mt_rand());
            $player->setStatus('pending');

            $factory = $this->container->get('security.encoder_factory');
            $encoder = $factory->getEncoder($player);
            $pwd = $encoder->encodePassword($player->getPassword(), $player->getSalt());
            $player->setPassword($pwd);

            $em = $this->getDoctrine()->getManager();
            $em->persist($player);
            $em->flush();
            $this->get('mail')->sendConfirmationEmail($player->getId(),$player->getGamertag(),$player->getEmail(),$player->getHash());
            return $this->render('PublicBundle:Home:subscriptionSuccess.html.twig',array('player'=>$player));
        }
        return $this->render('PublicBundle:Home:subscribePlayer.html.twig',array('form'=>$form->createView()));
    }

    public function subscriptionAction(Request $request){
        $form = $this->createForm(new PlayerType($this->getDoctrine()->getManager(),$this->get('logger')),new Player());
        $form->handleRequest($request);
        if ($form->isValid()) {
            $player = $form->getData();
            $player->setHash(mt_rand());
            $player->setStatus('pending');

            $factory = $this->container->get('security.encoder_factory');
            $encoder = $factory->getEncoder($player);
            $pwd = $encoder->encodePassword($player->getPassword(), $player->getSalt());
            $player->setPassword($pwd);

            $em = $this->getDoctrine()->getManager();
            $em->persist($player);
            $em->flush();
            $this->get('mail')->sendConfirmationEmail($player->getId(),$player->getName(),$player->getEmail(),$player->getHash());
            return $this->render('HomePublicBundle:Home:subscriptionSuccess.html.twig',array('player'=>$player));
        }
        return $this->render('HomePublicBundle:Home:subscription.html.twig',array('form'=>$form->createView()));
    }

    public function confirmAction($id){
        $em = $this->getDoctrine()->getManager();
        $player = $em->getRepository('HomePublicBundle:Player')->find($id);
        if($player->getHash() ==  $this->getRequest()->query->get('hash')){
            $player->setHash('');
            $player->setStatus('active');
            $em->persist($player);
            $em->flush();
            return $this->render('HomePublicBundle:Home:confirmSuccess.html.twig');
        }
    }

    public function loginAction(){
        $request = $this->getRequest();
        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                SecurityContext::AUTHENTICATION_ERROR
            );
        } elseif (null !== $session && $session->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = '';
        }

        $lastUsername = (null === $session) ? '' : $session->get(SecurityContext::LAST_USERNAME);

        $form = $this->createForm(new LoginType(),new Player(),array("action"=>$this->generateUrl('login_check'),));
        return $this->render('PublicBundle:Home:login.html.twig',array(
                'form'=>$form->createView(),
                'last_username' => $lastUsername,
                'error'         => $error,
            ));
    }
}
