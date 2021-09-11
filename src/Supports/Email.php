<?php

namespace SweetScar\AuthIgniter\Supports;

use SweetScar\AuthIgniter\Libraries\Email\Email as Sender;
use SweetScar\AuthIgniter\Entities\User;

class Email
{
    /**
     * Send email verification link to user
     * 
     * @param string $toEmail
     * @param string $token
     * 
     * @return bool
     */
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

    /**
     * Send reset password link to user
     * 
     * @param string $toEmail
     * @param string $token
     * 
     * @return bool
     */
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

    /**
     * Send password changed notification to user
     * 
     * @param User $user
     * 
     * @return bool
     */
    public static function sendPasswordChangedNotification(User $user): bool
    {
        $config = config('AuthIgniter');
        $content = view($config->views['email:password_changed_notification'], ['user' => $user]);

        $sender = new Sender('netcore');

        $sender->setFromEmail('r24072020@pepisandbox.com');
        $sender->setFromName('SweetScar\AuthIgniter');
        $sender->setToEmail($user->email);
        $sender->setToName($user->email);
        $sender->setSubject('[AuthIgniter] Your Account Password Was Changed');
        $sender->setContent($content);

        return $sender->send();
    }

    /**
     * Send registration success notification to user
     * 
     * @param User $user
     * 
     * @return bool
     */
    public static function sendRegistrationSuccessNotification(User $user): bool
    {
        $config = config('AuthIgniter');
        $content = view($config->views['email:registration_success_notification'], ['user' => $user]);

        $sender = new Sender();

        $sender->setFromEmail('r24072020@pepisandbox.com');
        $sender->setFromName('SweetScar\AuthIgniter');
        $sender->setToEmail($user->email);
        $sender->setToName($user->email);
        $sender->setSubject('[AuthIgniter] Thank You For Registering Your Account');
        $sender->setContent($content);

        return $sender->send();
    }
}
