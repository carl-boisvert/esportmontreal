<?php

namespace PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Home\PublicBundle\Entity\Game;
use Symfony\Component\HttpFoundation\Response;

class GamesController extends Controller
{

    public function indexAction()
    {
        $games = $this->getDoctrine()->getRepository('HomePublicBundle:Game')->findAll();

        return $this->render('HomePublicBundle:Home:games.html.twig',array('games'=>$games));
    }
}
