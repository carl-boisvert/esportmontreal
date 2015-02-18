<?php

namespace EsportBundle\Services;
use EsportBundle\Controller\GameController;
use EsportBundle\Controller\NotificationController;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\DependencyInjection\Container;
use EsportBundle\Interfaces\PreController;

class SessionVerification{

    private $session;
    private $container;

    public function __construct(Session $session, Container $container){
        $this->session = $session;
        $this->container = $container;
    }
    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();
        $event->setController($controller);
        /*if($controller[0] instanceof PreController && $this->container->get('security.context')->getToken()->getUser()){
            if(!$this->session->get('game') || !$this->session->get('console')){
                $controller = new GameController();
                $controller->setContainer($this->container);
                $callable = array($controller,'indexAction');
                $event->setController(array($controller,'indexAction'));
                $request = $event->getRequest()->query->add(array("noGame"=>1));
            }
            else{
                $event->setController($controller);
            }
        }
        else{
            $event->setController($controller);
        }*/

    }
    public function hasGame(){

    }



}