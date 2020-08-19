<?php

namespace Recruitment\MailTask\Service;

use Mailgun\Mailgun;
use Recruitment\MailTask\Interfaces\Mailer;
use Recruitment\MailTask\Model\Mail;

class MailgunMailer implements Mailer
{
    private $client;
    private $domain;
    private $from;

    public function __construct($domain, $from, $apiKey, $apiHostname)
    {
        $this->client = Mailgun::create($apiKey, $apiHostname);
        $this->domain = $domain;
        $this->from = $from;
    }

    public function send(Mail $mail): void
    {
        $params = [
            'from' => $this->from,
            'to' => $mail->toAddress,
            'subject' => $mail->subject,
            'text' => $mail->body,
        ];

        $this->client->messages()->send($this->domain, $params);
    }
}
