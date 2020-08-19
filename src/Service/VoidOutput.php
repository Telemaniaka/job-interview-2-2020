<?php

namespace Recruitment\MailTask\Service;

use Recruitment\MailTask\Interfaces\Output;

class VoidOutput implements Output
{
    public function print(string $message)
    {
        // just ignore the log messages for this app
    }
}
