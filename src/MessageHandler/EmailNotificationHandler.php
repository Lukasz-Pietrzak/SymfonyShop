<?php
namespace App\MessageHandler;

use App\Message\EmailNotification;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Mime\Address;

#[AsMessageHandler]
class EmailNotificationHandler
{
    public function __construct(private MailerInterface $mailer)
    {
    }

    public function __invoke(EmailNotification $emailNotification)
    {
        $email = (new TemplatedEmail())
            ->to(new Address($emailNotification->getAdressTo()))
            ->subject($emailNotification->getSubject())
            ->htmlTemplate($emailNotification->getHtmlTemplate())
            ->context([
                'expiration_date' => new \DateTime('+7 days'),
                'username' => $emailNotification->getUsername(),
            ]);

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            error_log('Email sending failed: ' . $e->getMessage());

            echo 'Sorry, there was an error sending the email. Please try again later.';
        }
    }
}
