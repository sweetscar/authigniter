<?php

namespace SweetScar\AuthIgniter\Libraries\Email;

use SweetScar\AuthIgniter\Libraries\Email\EmailInterface;
use SweetScar\AuthIgniter\Libraries\Email\BaseEmail;

class DefaultEmail extends BaseEmail implements EmailInterface
{
    public function send(string $fromEmail, string $fromName, string $toEmail, string $toName, string $subject, string $content): bool
    {
        return true;
    }
}
