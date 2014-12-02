<?php

namespace PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function indexAction()
    {
        return $this->render('PublicBundle:Home:index.html.twig');
    }

    public function subscribeAction()
    {
        return $this->render('PublicBundle:Home:subscription.html.twig');
    }
}
