# Authentication and Authorization Library for Codeigniter 4.

This library provides an easy and simple way to create login, logout, and user registration features for your Codeigniter 4 projects.

## Requirements

- PHP 8.0+
- CodeIgniter 4.1+

## Features

Currently this library has the following main features.

- User registration
- User login/logout
- Forgot password
- Email verification
- Email notification
- User group

## Instalation

Installation is best done via Composer. Assuming Composer is installed globally, you may use the following command:
```bash
composer require sweetscar/authigniter
```
This will add the latest stable release of SweetScar\AuthIgniter as a module to your project.

## Configuration

Once installed you need to configure the framework to use the SweetScar\AuthIgniter library.

Ensure your database is setup correctly, then run the AuthIgniter migrations:
```bash
php spark migrate -all
```
After the migration is complete, this library already provides basic authentication for your application with the following default configuration.

```php
public $defaultUserGroup = 'default';
public $authenticationLibraries = [
    'local' => 'SweetScar\AuthIgniter\Libraries\Authentication\LocalAuthentication',
];
public $authorizationLibraries = [
    'default' => 'SweetScar\AuthIgniter\Libraries\Authorization\DefaultAuthorization'
];
public $accountManager = [
    'default' => 'SweetScar\AuthIgniter\Libraries\Account\DefaultAccountManager'
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
public $defaultEmailLibrary = 'default';
public $activeEmailNotifications = [];
public $enableForgotPassword = true;
public $enableUsername = true;
public $minimumUsernameLength = 8;
public $maximumUsernameLength = 30;
public $requireEmailVerification = false;
public $emailVerificationDeadline = 30 * DAY;
public $userActivatedAsDefault = true;
public $successLoginRedirect = '/';
public $successLogoutRedirect = '/login';
public $hashAlgorithm = PASSWORD_DEFAULT;
public $minimumPasswordLength = 8;
public $maximumPasswordLength = 30;
public $tokenExpiryTime = ['email_verification' => 1800, 'reset_password' => 3600];
```

## Services
## Helper Functions
## User
## Authentice The User
## Authorize The User
## Events

1. user_created (User $user)
2. user_updated (User $user)
3. user_deleted_permanently (User $user)
4. user_deleted (User $user)
5. user_activated (User $user)
6. user_deactivated (User $user)