<?php

namespace EsportBundle\Services;

class Mail{

    private $mailService;
    private $renderer;

    public function __construct(\Swift_Mailer $mailler, $renderer){
        $this->mailService = $mailler;
        $this->renderer = $renderer;
    }

    public function sendConfirmationEmail($id,$name, $email, $hash){
        /*$message = \Swift_Message::newInstance()
            ->setSubject('Confirm your email')     // we configure the title
            ->setFrom('noreply@carlboisvert.com')     // we configure the sender
            ->setTo($email)     // we configure the recipient
            ->setBody($this->renderer->render('HomePublicBundle:Email:confirmEmail.html.twig', array('id'=>$id,'name' => $name, 'hash'=>$hash)));
        $this->mailService->send($message);*/
    }



}