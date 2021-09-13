This library provides an easy and simple way to create login, logout, and user registration features for your CodeIgniter 4 projects.

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
- Group based authorization

## Instalation

#### Composer Installation
Assuming Composer is installed globally, you may use the following command:
```bash
composer require sweetscar/authigniter
```
This will add the SweetScar\AuthIgniter as a module to your project.

**Note:** 
This library is still in beta version. So you have to set the minimum stability of your project to "beta", or you can include the version explicitly when running ```composer require``` command.

Example:
```bash
composer require sweetscar/authigniter:v1.0-beta
```
#### Manual Instalation
If you choose not to use composer to install, You can download or clone this library repository then enable it by editing **app/Config/Autoload.php** and add the SweetScar\AuthIgniter namespace to the ```$psr4``` array. For example if you copied the library into **app/ThirdParty**:
```php
$psr4 = [
    'Config'                => APPPATH . 'Config',
    APP_NAMESPACE           => APPPATH,
    'App'                   => APPPATH,
    'SweetScar\AuthIgniter' => APPPATH .'ThirdParty/sweetscar/authigniter/src',
];
```

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
public $enableForgotPassword = false;
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
#### Authenticate Users

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

##### Logging out the user
To perform the logout process, you simply create a form with the "POST" method, and navigate to the logout route. For example:
```html
<form action="/logout" method="POST">
    <!-- don't forget to add csrf field -->
    <button type="submit">Logout</button>
</form>
```

You can use the helper from CodeIgniter ```route_to()``` and pass ```autigniter:logout``` in the parameters to fill out form action.
Example:
```php
route_to('authigniter:logout');
```

**Note:** You may want to check all the named routes provided [here](#available-named-routes).


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

- user_created (User $user)
- user_updated (User $user)
- user_deleted_permanently (User $user)
- user_deleted (User $user)
- user_activated (User $user)
- user_deactivated (User $user)
- user_logged_in (User $user)
- user_logged_out (User $user)

## Available Named Routes

- ```GET``` ```authigniter:login``` | Show login page
- ```POST``` ```authigniter:attemptLogin``` | Submit login form
- ```POST``` ```authigniter:logout``` | Submit logout form
- ```GET``` ```authigniter:register``` | Show registration form
- ```POST``` ```authigniter:attemptRegister``` | Submit registration form

**Only available if ```$enableForgotPassword``` in the Configuration is ```true```**

- ```GET``` ```authigniter:forgotPassword``` | Show forgot password form
- ```POST``` ```authigniter:attemptForgotPassword``` | Submit forgot password form
- ```GET``` ```authigniter:resetPassword``` | Display reset password form
- ```POST``` ```authigniter:attemptResetPassword``` | Submit reset password form
- ```GET``` ```authigniter:resetPasswordResult``` | Show reset password result

**Only available if ```$requireEmailVerification``` in the Configuration is ```true```**

- ```GET``` ```authigniter:verifyEmail``` | Verify email and show the result

## Available Commands

- ai:create_user
- ai:delete_user
- ai:activate_user
- ai:deactivate_user
- ai:list_groups
- ai:create_group
- ai:update_group
- ai:delete_group
- ai:list_user_groups
- ai:add_user_to_group
- ai:remove_user_from_group

Example usage:
```bash
php spark ai:create_user
```

## Customization

Library customization is very easy to do. As a first step, Copy the configuration file from ```src/Config/AuthIgniter.php``` to ```app/Config/AuthIgniter.php``` and change class extend to ```SweetScar\AuthIgniter\Config\AuthIgniter```

For example:
```php
<?php

namespace SweetScar\AuthIgniter\Config;

use CodeIgniter\Config\BaseConfig;

class AuthIgniter extends BaseConfig
{
    //
}
```
Change to:
```php
<?php

namespace SweetScar\AuthIgniter\Config;

use SweetScar\AuthIgniter\Config\AuthIgniter as AuthConfig;

class AuthIgniter extends AuthConfig
{
    //
}
```

Now, you can configure according to your project needs.

**Note:**
By default, AuthIgniter uses the CodeIgniter email library to send email. So, if you want to enable features related to sending email, like forgot password, email verification, notification, etc, please make sure the email configuration is done and make sure your project can send email.

As an alternative, Currently AuthIgniter also provides a library for sending email using the services of the Netcore Email API. To use this email library, you must perform the following steps.

First, make sure you already have an account at Netcore Email Api. If you don't, [Create here](https://netcorecloud.com/)

Then get the API URL and API Key for your account from there.

On your env file, Add the following variable:

```
authigniteremail.netcore.url = [Your email API URL]
authigniteremail.netcore.api_key = [your API Key]
```
Now, change the default email library in AuthIgniter Config

```php
$defaultEmailLibrary = 'netcore';
```
and we are done.

#### Customizing The View Templates

If you want to use your own view file, just point the view configuration to the location of your view file.
For example:
```php
public $views = [
    'login' => 'auth/login',
];
```

AuthIgniter extends view layouts to create login, register, etc. views. If you want to extend your view layout, simply update the ```$viewLayout``` configuration.
For example:

```php
public $viewLayout = 'templates/layout';
```