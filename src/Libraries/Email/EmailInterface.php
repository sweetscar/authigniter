<?php

namespace SweetScar\AuthIgniter\Libraries\Email;

interface EmailInterface
{
    public function send(
        string $fromEmail,
        string $fromName,
        string $toEmail,
        string $toName,
        string $subject,
        string $content
    ): bool;
}
