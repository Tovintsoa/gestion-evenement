<?php


namespace App\Service;


use Twig\Environment;

class SendMailService
{

    private $mailer;
    private $twig;
    private $from = ['tovintsoa.manao@gmail.com'];

    public function __construct(\Swift_Mailer $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function send($to, $subject, $body)
    {
        $message = (new \Swift_Message($subject))
            ->setFrom($this->from)
            ->setTo($to)
            ->setBody($body, 'text/html');
        return $this->mailer->send($message);
    }
}