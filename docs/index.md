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
The following Services are provided by the package.

##### authentication

Provides access to any of the authentication packages. By default it will return the "Local Authentication" library, which is the basic password-based system.

```php
$authentication = service('authentication');
```

##### authorization

Provides access to any of the authorization libraries. By default it will return the Default authorization library. It provides user group based permissions.

```php
$authorization = service('authorization');
```

##### account

Provides access to any of the user account manager. By default it will return the Default Account Manager. Used to manage user account like create, update, delete activate, etc.

```php
$account = service('account');
```

## Helper Functions

##### authenticated()
Check if user has logged in or not.
- Parameters: None
- Returns: ```true``` or ```false```

##### user()
Get detail of current logged user.
- Parameters: None
- Returns: Current logged user entity or ```null```

##### in_group()
Check if the current authenticated user is a member of a group.
- Parameters: ```string``` Group name
- Returns: ```true``` or ```false```

## User

This library uses CodeIgniter Entities for it's User object, and your application must also use that class. This class provides automatic password hashing.

## Restricting Access

First, edit application/Config/Filters.php and add the following entries to the aliases property:

```php
'authenticate'  => \SweetScar\AuthIgniter\Filters\AuthenticationFilter::class,
'authorize'     => \SweetScar\AuthIgniter\Filters\AuthorizationFilter::class,
```
#### Authentice The User

The authentication filter is restrict access if user not logged in. If user not logged in, user will redirected to login form. This filter not require additional parameters so you can use this filter to restrict the the user by URI pattern.

```php
public filters = [
    'authenticate' => ['before' => ['account/*']],
];
```

or restrict entire site:

```php
   public $globals = [
        'before' => [
            'honeypot',
            'authenticate',
    ...
```

Any single route can be restricted by adding the filter option to the last parameter in any of the route definition methods:

```php
$routes->get('admin', 'AdminController::index', ['filter' => 'authenticate']);
```
#### Authorize The User

The authorizatin filter is used to restrict access to some routes based on groups authorization, this filter will check if user has logged in and check if user is member of spesific group or not. This filter require additional parameters, the name of group that allowed to access routes.

For example, if you want to allow all user that is member of "admin" group only and restrict other group, it will look like this.

```php
$routes->get('admin', 'AdminController::index', ['filter' => 'authorize:admin']);
```

If any other logged user accessing to this routes and the user is not member of admin group, user will redirected to 403 Forbidden error, indicating that user does not have permission to access the page.

>Tips:
> If you want to allow all group to access the route, just put star (*) on the filter parameter,
```php
['filter' => 'authorize:*']
```

#### Events
AuthIgniter trigger some important event that you may want to do something when the event is triggered.

1. user_created (User $user)
2. user_updated (User $user)
3. user_deleted_permanently (User $user)
4. user_deleted (User $user)
5. user_activated (User $user)
6. user_deactivated (User $user)
7. user_logged_in (User $user)
8. user_logged_out (User $user)