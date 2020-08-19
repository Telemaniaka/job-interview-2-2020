<?php

namespace Recruitment\MailTask\Interfaces;

use Recruitment\MailTask\Model\Mail;

interface Mailer
{
    public function send(Mail $mail): void;
}
