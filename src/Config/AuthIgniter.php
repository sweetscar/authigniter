<?php

namespace SweetScar\AuthIgniter\Config;

use CodeIgniter\Config\BaseConfig;

class AuthIgniter extends BaseConfig
{
    /**
     * The default group that will be assigned to the new user.
     * 
     * @var string
     */
    public $defaultUserGroup = 'default';

    /**
     * Authentication library available for user authentication process.
     * 
     * @var array
     */
    public $authenticationLibraries = [
        'local' => 'SweetScar\AuthIgniter\Libraries\Authentication\LocalAuthentication',
    ];

    /**
     * Authorization library available for user authorization process.
     * 
     * @var array
     */
    public $authorizationLibraries = [
        'default' => 'SweetScar\AuthIgniter\Libraries\Authorization\DefaultAuthorization'
    ];

    /**
     * User account manager.
     * 
     * @var array
     */
    public $accountManager = [
        'default' => 'SweetScar\AuthIgniter\Libraries\Account\DefaultAccountManager'
    ];

    /**
     * List of views used by the AuthIgniter controller.
     * 
     * @var array
     */
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

    /**
     * Layout to be extended by view.
     * 
     * @var string
     */
    public $viewLayout = 'SweetScar\AuthIgniter\Views\layout';

    /**
     * The library used for the process of sending email.
     * 
     * @var array
     */
    public $emailLibraries = [
        'default' => 'SweetScar\AuthIgniter\Libraries\Email\DefaultEmail',
        'netcore' => 'SweetScar\AuthIgniter\Libraries\Email\NetcoreEmail'
    ];

    /**
     * The email library used by default.
     * 
     * The value is based on the list of email libraries available in $emailLibraries.
     * 
     * @var string
     */
    public $defaultEmailLibrary = 'default';

    /**
     * Activated email notification list.
     * 
     * 
     * Available notification:
     * 1. registration_success
     * 2. password_changed
     * 
     * Make sure the email configuration is correct if you enable this feature.
     * 
     * @var array
     */
    public $activeEmailNotifications = [];

    /**
     * Forgot password feature.
     * 
     * If the value is true, then the user can request a password reset.
     * 
     * Make sure the email configuration is correct if you enable this feature.
     * 
     * @var bool
     */
    public $enableForgotPassword = false;

    /**
     * Allow remembering
     * 
     * If the value is true, then the user can 
     */

    /**
     * Username feature.
     * 
     * If the value is true, the user will be asked to create a username when registering an account
     * and can login using email or username.
     * 
     * @var bool
     */
    public $enableUsername = true;

    /**
     * Minimum username length.
     * 
     * Minimum username length used during the registration process.
     * Valid value: 3 to 6.
     * 
     * @var int
     */
    public $minimumUsernameLength = 8;

    /**
     * Maximum username lenght.
     * 
     * Maximum username lenght used during the registration process.
     * Valid value: 6 to 30.
     * 
     * @var int 
     */
    public $maximumUsernameLength = 30;

    /**
     * Email verification.
     * 
     * If the value is true, then the user is required to verify the email used to register the account.
     * A verification link will be sent to the email address used to register automatically upon successful account registration.
     * 
     * Make sure the email configuration is correct if you enable this feature
     * 
     * @var bool
     */
    public $requireEmailVerification = false;

    /**
     * Email verification deadline.
     * 
     * The amount of time, in second that you want for email address verification deadline.
     * The default value is 30 days from the first account created.
     * 
     * @var int
     */
    public $emailVerificationDeadline = 30 * DAY;

    /**
     * Default user active status.
     * 
     * If the value is true, then the user account will be activated immediately upon registration.
     * 
     * @var bool
     */
    public $userActivatedAsDefault = true;

    /**
     * Success login redirection.
     * 
     * The route to redirect when the user is successfully logged in.
     * 
     * @var string
     */
    public $successLoginRedirect = '/';

    /**
     * Success logout redirection.
     * 
     * The route to redirect when the user is successfully logged out.
     * 
     * @var string
     */
    public $successLogoutRedirect = '/login';

    /**
     * Encryption algorithm to use.
     *
     * Valid values are
     * - PASSWORD_DEFAULT (default)
     * 
     * @var string|int
     */
    public $hashAlgorithm = PASSWORD_DEFAULT;

    /**
     * Minimum password length.
     * 
     * Minimum password length used during the registration process.
     * Valid value: 6 to 15.
     * 
     * @var int
     */
    public $minimumPasswordLength = 8;

    /**
     * Maximum password lenght.
     * 
     * Maximum password lenght used during the registration process.
     * Valid value: 15 to 30.
     * 
     * @var int 
     */
    public $maximumPasswordLength = 30;

    /**
     * Token expiration time.
     * 
     * The amount of time in seconds that token will expired.
     * 
     * @var array
     */
    public $tokenExpiryTime = ['email_verification' => 1800, 'reset_password' => 3600]; // in seccond
}
