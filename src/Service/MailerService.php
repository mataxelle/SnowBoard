<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerService
{
    /**
     * mailer
     *
     * @var mixed
     */
    private $mailer;

    /**
     * Constructor
     *
     * @param MailerInterface $mailer Mailer
     * @return void
     */
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;

    }
    
    /**
     * sendEmail
     *
     * @return void
     */
    public function sendEmail(): void
    {
        $email = (new Email())
            ->from('')
            ->to('')
            ->subject('1Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $this->mailer->send($email);
    }
}
