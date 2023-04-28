<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmail(
        string $from,
        string $to,
        string $subject,
        string $template,
        array $context
    ): void
    {
        $subject = 'Validez votre inscription !';
        $content = '<p>Votre lien de confirmation d\'inscripetion</p>';
        $email = (new TemplatedEmail())
            ->from($from)
            ->to($to)
            ->subject($subject)
            ->htmlTemplate("emails/$template.html.twig")
            ->html($content);

        $this->mailer->send($email);
    }
}