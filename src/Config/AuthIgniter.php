<?php

namespace SweetScar\AuthIgniter\Config;

use CodeIgniter\Config\BaseConfig;

class AuthIgniter extends BaseConfig
{
    public $defaultUserRole = '';
    public $views = [
        'login' => 'SweetScar\AuthIgniter\Views\login',
        'register' => 'SweetScar\AuthIgniter\Views\register',
        'forgot_password' => 'SweetScar\AuthIgniter\Views\forgot_password',
    ];
    public $viewLayout = 'SweetScar\AuthIgniter\Views\layout';
    public $enableUsername = true;
    public $enableForgotPassword = true;
    public $enableEmailVerification = false;
    public $loginPageTitle = 'AuthIgniter.loginPageTitle';
    public $registerPageTitle = 'AuthIgniter.registerPageTitle';
    public $forgotPasswordPageTitle = 'Authigniter.requestResetPasswordLink';
    public $hashAlgorithm = PASSWORD_DEFAULT;
    public $minimumPasswordLength = 8;
    public $tokenExpiryTime = 3600;
}
