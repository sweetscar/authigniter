<?php

namespace SweetScar\AuthIgniter\Libraries\Email;

interface EmailInterface
{
    /**
     * Send email
     * 
     * @param string $fromEmail
     * @param string $fromName
     * @param string $toEmail
     * @param string $toName
     * @param string $subject
     * @param string $content
     * 
     * @return bool
     */
    public function send(
        string $fromEmail,
        string $fromName,
        string $toEmail,
        string $toName,
        string $subject,
        string $content
    ): bool;
}
