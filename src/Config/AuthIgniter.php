<?php

namespace SweetScar\AuthIgniter\Config;

use CodeIgniter\Config\BaseConfig;

class AuthIgniter extends BaseConfig
{
    public $defaultUserRole = 'default';
    public $authenticationLibs = [
        'local' => 'SweetScar\AuthIgniter\Libraries\Authentication\LocalAuthentication',
    ];
    public $views = [
        'login' => 'SweetScar\AuthIgniter\Views\login',
        'register' => 'SweetScar\AuthIgniter\Views\register',
        'forgot_password' => 'SweetScar\AuthIgniter\Views\forgot_password',
        'reset_password' => 'SweetScar\AuthIgniter\Views\reset_password',
        'reset_password_result' => 'SweetScar\AuthIgniter\Views\reset_password_result',
        'verify_email_result' => 'SweetScar\AuthIgniter\Views\verify_email_result',
        'email:email_verification_link' => 'SweetScar\AuthIgniter\Views\Email\email_verification_link',
        'email:reset_password_link' => 'SweetScar\AuthIgniter\Views\Email\reset_password_link',
        'email:password_changed_notification' => 'SweetScar\AuthIgniter\Views\Email\password_changed_notification',
        'email:registration_success_notification' => 'SweetScar\AuthIgniter\Views\Email\registration_success_notification',
    ];
    public $viewLayout = 'SweetScar\AuthIgniter\Views\layout';
    public $emailLibraries = [
        'default' => 'SweetScar\AuthIgniter\Libraries\Email\DefaultEmail',
        'netcore' => 'SweetScar\AuthIgniter\Libraries\Email\NetcoreEmail'
    ];
    public $defaultEmailLibrary = 'netcore';
    public $enableUsername = true;
    public $enableForgotPassword = true;
    public $activeEmailNotifications = ['registration_success', 'password_changed'];
    public $requireEmailVerification = true;
    public $userActivatedAsDefault = true;
    public $autoLoginAfterRegister = false;
    public $successLoginRedirect = '/';
    public $hashAlgorithm = PASSWORD_DEFAULT;
    public $minimumPasswordLength = 8;
    public $tokenExpiryTime = ['email_verification' => 1800, 'reset_password' => 3600]; // in seccond
}
