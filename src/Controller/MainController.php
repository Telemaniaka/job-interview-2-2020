<?php

namespace Recruitment\MailTask\Controller;

use Recruitment\MailTask\Interfaces\Mailer;
use Recruitment\MailTask\Model\Mail;
use Recruitment\MailTask\Service\Validator;

class MainController
{
    private $mailer;
    private $template;

    public function __construct(Mailer $mailer, $template)
    {
        $this->mailer = $mailer;
        $this->template = $template;
    }

    public function indexAction()
    {
        $this->template->display('EmailForm.html');
    }

    public function submitAction()
    {
        $validator = new Validator([
            ['email', 'emailType'],
            ['subject', 'plainTextType'],
            ['body', 'plainEmailBodyType'],
        ]);

        $params = $validator->getData();

        if ($validator->hasErrors()) {
            $this->template->display('EmailForm.html', [
                'errors' => $validator->getErrors(),
                'values' => $params,
            ]);

            return;
        }

        $mail = new Mail();
        $mail->toAddress = $params['email'];
        $mail->subject = $params['subject'];
        $mail->body = $params['body'];

        $this->mailer->send($mail);

        $this->template->display('SendSuccess.html');
    }
}
