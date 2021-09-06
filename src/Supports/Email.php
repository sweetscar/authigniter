<?php

namespace SweetScar\AuthIgniter\Supports;

use SweetScar\AuthIgniter\Libraries\Email\Email as Sender;

class Email
{
    public static function sendEmailVerificationLink(string $toEmail, string $token): bool
    {
        $config = config('AuthIgniter');
        $link = base_url() . route_to('authigniter:verifyEmail') . '?email=' . $toEmail . '&token=' . $token;
        $content = view($config->views['email:email_verification_link'], ['link' => $link]);

        $sender = new Sender();

        $sender->setFromEmail('r24072020@pepisandbox.com');
        $sender->setFromName('SweetScar\AuthIgniter');
        $sender->setToEmail($toEmail);
        $sender->setToName($toEmail);
        $sender->setSubject('[AuthIgniter] Email Address Verification Link');
        $sender->setContent($content);

        return $sender->send();
    }

    public static function sendResetPasswordLink(string $toEmail, string $token): bool
    {
        $config = config('AuthIgniter');
        $link = base_url() . route_to('authigniter:resetPassword') . '?token=' . $token;
        $content = view($config->views['email:reset_password_link'], ['link' => $link]);

        $sender = new Sender();

        $sender->setFromEmail('r24072020@pepisandbox.com');
        $sender->setFromName('SweetScar\AuthIgniter');
        $sender->setToEmail($toEmail);
        $sender->setToName($toEmail);
        $sender->setSubject('[AuthIgniter] Reset Password Link');
        $sender->setContent($content);

        return $sender->send();
    }
}
