<?php

namespace SweetScar\AuthIgniter\Libraries\Email;

use SweetScar\AuthIgniter\Libraries\Email\EmailInterface;
use SweetScar\AuthIgniter\Libraries\Email\BaseEmail;

class DefaultEmail extends BaseEmail implements EmailInterface
{
    /**
     * {@inheritdoc}
     */
    public function send(string $fromEmail, string $fromName, string $toEmail, string $toName, string $subject, string $content): bool
    {
        $email = service('email');

        $email->setFrom($fromEmail, $fromName);
        $email->setTo($toEmail);
        $email->setSubject($subject);
        $email->setMessage($content);

        if (!$email->send(false)) {
            $this->setError($email->printDebugger());
            return false;
        }
        return true;
    }
}
