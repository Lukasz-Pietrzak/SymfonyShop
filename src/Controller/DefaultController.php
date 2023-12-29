<?php

namespace App\Controller;

use App\Message\EmailNotification;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\File;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/default', name: 'app_default')]
    public function index(MessageBusInterface $bus): Response
    {
        $bus->dispatch(new EmailNotification(
            'bingo216pt@gmail.com',
            'Confirm your email address',
            'emails/signup.html.twig',
            'Lukasiero'
        ));
        
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);

    }

}
