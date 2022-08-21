<?php

namespace SweetScar\AuthIgniter\Controllers;

use App\Controllers\BaseController;
use SweetScar\AuthIgniter\Entities\User;
use SweetScar\AuthIgniter\Supports\Email;
use SweetScar\AuthIgniter\Libraries\Token\EmailVerificationToken;
use SweetScar\AuthIgniter\Libraries\Token\ResetPasswordToken;

class AuthIgniter extends BaseController
{
    protected $config;
    protected $session;
    protected $validation;
    protected $emailVerificationToken;
    protected $resetPasswordToken;
    protected $authentication;
    protected $authorization;
    protected $account;

    /**
     * Construction of all our needs here.
     */
    public function __construct()
    {
        session();

        $this->session = service('session');
        $this->config = config('AuthIgniter');
        $this->validation = service('validation');
        $this->emailVerificationToken = new EmailVerificationToken();
        $this->resetPasswordToken = new ResetPasswordToken();
        $this->authentication = service('authentication');
        $this->authorization = service('authorization');
        $this->account = service('account');
    }

    /**
     * Show the page for logged in users.
     */
    public function login()
    {
        // if user has logged in, redirect to base url
        if ($this->authentication->check()) return redirect()->to(base_url());

        $data['config'] = $this->config;

        return view($this->config->views['login'], $data);
    }

    /**
     * Attempting to log the user into the application.
     */
    public function attemptLogin()
    {
        // if user has logged in, redirect to base url
        if ($this->authentication->check()) return redirect()->to(base_url());

        $rules = [
            'login' => [
                'rules' => 'required'
            ],
            'password' => [
                'rules' => 'required'
            ]
        ];

        if (!$this->config->enableUsername) {
            $rules['login']['rules'] .= '|valid_email';
        }

        if (!$this->validate($rules)) {
            return redirect('authigniter:login')->withInput()->with('errors', $this->validator->getErrors());
        }

        $login = $this->request->getPost('login');
        $password = $this->request->getPost('password');
        $type = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // try to log the user into application
        $attempt = $this->authentication->attempt([$type => $login, 'password' => $password]);

        if (!$attempt) {
            return redirect('authigniter:login')->with('authigniter_error', $this->authentication->error());
        }

        $redirectURL = session('redirect_url') ?? site_url($this->config->successLoginRedirect);

        session()->remove('redirect_url');

        return redirect()->to($redirectURL)->with('authigniter_info', lang('AuthIgniter.loginSuccess'));
    }

    /**
     * User logout from the app
     */
    public function logout()
    {
        // Destroy the user session
        if ($this->authentication->destroy()) {
            return redirect()->to($this->config->successLogoutRedirect)->with('authigniter_info', lang('AuthIgniter.logoutSuccess'));
        }
        return redirect()->back();
    }

    /**
     * Show page for new user registration.
     */
    public function register()
    {
        // if user has logged in, redirect to base url
        if ($this->authentication->check()) return redirect()->to(base_url());

        $data['config'] = $this->config;

        return view($this->config->views['register'], $data);
    }

    /**
     * Trying to create a new user account.
     */
    public function attemptRegister()
    {
        // if user has logged in, redirect to base url.
        if ($this->authentication->check()) return redirect()->to(base_url());

        $minPasswordLength = $this->config->minimumPasswordLength;
        $minPasswordLength = ($minPasswordLength < 6 || $minPasswordLength > 15) ? 6 : $minPasswordLength;
        $maxPasswordLength = $this->config->maximumPasswordLength;
        $maxPasswordLength = ($maxPasswordLength < 15 || $maxPasswordLength > 30) ? 30 : $maxPasswordLength;

        $minUsernameLength = $this->config->minimumUsernameLength;
        $minUsernameLength = ($minUsernameLength < 3 || $minUsernameLength > 6) ? 3 : $minUsernameLength;
        $maxUsernameLength = $this->config->maximumUsernameLength;
        $maxPasswordLength = ($maxUsernameLength < 6 || $maxUsernameLength > 30) ? 30 : $maxUsernameLength;

        $rules = [
            'email' => [
                'label' => lang('AuthIgniter.email'),
                'rules' => 'required|valid_email|is_unique[users.email]'
            ],
            'password' => [
                'label' => lang('AuthIgniter.password'),
                'rules' => "required|min_length[$minPasswordLength]|max_length[$maxPasswordLength]"
            ],
            'repeat-password' => [
                'label' => lang('AuthIgniter.repeatPassword'),
                'rules' => 'required|matches[password]'
            ],
        ];

        if ($this->config->enableUsername) {
            $rules['username'] = [
                'label' => lang('AuthIgniter.username'),
                'rules' => "required|min_length[$minUsernameLength]|max_length[$maxUsernameLength]|is_unique[users.username]alpha_numeric"
            ];
        }

        if (!$this->validate($rules)) {
            return redirect('authigniter:register')->withInput()->with('errors', $this->validator->getErrors());
        }

        // create new user entity
        $user = new User();
        $user->setEmail($this->request->getPost('email'));
        $user->setEmail($this->request->getPost('email'));
        if ($this->config->enableUsername) {
            $user->setUsername($this->request->getPost('username'));
        }
        $user->setPassword($this->request->getPost('password'));
        ($this->config->userActivatedAsDefault) ? $user->activate() : $user->deactivate();
        ($this->config->requireEmailVerification) ? $user->unverifyEmail() : $user->setEmailIsVerified(true);

        // create account from user entity
        $userAccount = $this->account->create($user, true);

        if ($userAccount) {
            $this->authorization->addUserToGroup($userAccount, $this->config->defaultUserGroup);
            // if user is required to verify email address, create token and send it to user email.
            if ($this->config->requireEmailVerification) {
                $token = $this->emailVerificationToken->create($userAccount);
                if ($token) {
                    Email::sendEmailVerificationLink($user->email, $token);
                }
            }
            return redirect('authigniter:login')->with('authigniter_info', lang('AuthIgniter.registrationSuccess'));
        }
        return redirect('authigniter:register')->with('authigniter_error', $this->account->error());
    }

    /**
     * Verify user email address
     */
    public function verifyEmail()
    {
        $email = $this->request->getGet('email');
        $token = $this->request->getGet('token');
        $data['config'] = $this->config;
        $data['type'] = 'error';
        $data['message'] = '';

        if (!$email) {
            $data['message'] = lang('AuthIgniter.emailVerification.linkInvalid');
        } elseif (!$token) {
            $data['message'] = lang('AuthIgniter.emailVerification.linkInvalid');
        } else {
            $verifyToken = $this->emailVerificationToken->verify($token);
            if (!$verifyToken) {
                $data['message'] = $this->emailVerificationToken->getErrorMessage();
            } else {
                if (!$this->emailVerificationToken->getTokenOwner() == $email) {
                    $data['message'] = lang('AuthIgniter.emailVerification.linkInvalid');
                } else {
                    $userAccount = $this->account->get(['email' => $email]);
                    $verifyUserEmail = $this->account->verifyEmail($userAccount);
                    if (!$verifyUserEmail) {
                        $data['message'] = lang('AuthIgniter.errorHasOccured');
                    } else {
                        $data['type'] = 'success';
                        $data['message'] = lang('AuthIgniter.emailVerification.success');
                    }
                }
            }
        }

        return view($this->config->views['verify_email_result'], $data);
    }

    /**
     * Show forgot password form.
     */
    public function forgotPassword()
    {
        // if user has logged in, redirect to base url
        if ($this->authentication->check()) return redirect()->to(base_url());

        $data['config'] = $this->config;

        return view($this->config->views['forgot_password'], $data);
    }

    /**
     * Try to 
     */
    public function attemptForgotPassword()
    {
        // if user has logged in, redirect to base url
        if ($this->authentication->check()) return redirect()->to(base_url());

        $rules = [
            'email' => [
                'rules' => 'required|valid_email'
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect('authigniter:forgotPassword')->withInput()->with('errors', $this->validator->getErrors());
        }

        $email = $this->request->getPost('email');

        $userAccount = $this->account->get(['email' => $email]);

        if (is_null($userAccount)) {
            return redirect('authigniter:forgotPassword')->withInput()->with('authigniter_error', lang('AuthIgniter.resetPassword.accountNotFound'));
        }

        // create reset password token
        $token = $this->resetPasswordToken->create(
            $email,
            $this->request->getIPAddress(),
            (string)$this->request->getUserAgent()
        );

        if (!$token) {
            return redirect('authigniter:forgotPassword')->with('authigniter_error', lang('AuthIgniter.errorHasOccured'));
        }

        $emailSent = Email::sendResetPasswordLink($email, $token);

        if (!$emailSent) {
            return redirect('authigniter:forgotPassword')->with('authigniter_error', lang('AuthIgniter.resetPassword.failedToSendLink'));
        }

        return redirect('authigniter:forgotPassword')->with('authigniter_info', lang('AuthIgniter.resetPassword.successToSendLink'));
    }

    /**
     * Show reset password form
     */
    public function resetPassword()
    {
        // if user has logged in, redirect to base url
        if ($this->authentication->check()) return redirect()->to(base_url());

        $token = $this->request->getGet('token');
        $data['config'] = $this->config;
        $data['resetPasswordToken'] = $token;

        if (!$token) {
            return redirect('authigniter:resetPasswordResult')->with('reset_password_result', ['type' => 'error', 'message' => lang('AuthIgniter.resetPassword.linkInvalid')]);
        }

        // verify the forgot password token
        $verifyToken = $this->resetPasswordToken->verify($token);

        if (!$verifyToken) {
            return redirect('authigniter:resetPasswordResult')->with('reset_password_result', ['type' => 'error', 'message' => $this->resetPasswordToken->getErrorMessage()]);
        }

        return view($this->config->views['reset_password'], $data);
    }

    /**
     * Try to reset user password
     */
    public function attemptResetPassword()
    {
        // if user has logged in, redirect to base url
        if ($this->authentication->check()) return redirect()->to(base_url());

        $rules = [
            'new-password' => [
                'label' => lang('AuthIgniter.newPassword'),
                'rules' => 'required|min_length[8]'
            ],
            'repeat-new-password' => [
                'label' => lang('AuthIgniter.repeatNewPassword'),
                'rules' => 'required|matches[new-password]'
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // verify the reset password token
        $verifyToken = $this->resetPasswordToken->verify($this->request->getPost('token'));

        if (!$verifyToken) {
            return redirect('authigniter:resetPasswordResult')->with('reset_password_result', ['type' => 'error', 'message' => $this->resetPasswordToken->getErrorMessage()]);
        }

        // updating user password
        $newPassword = $this->request->getPost('new-password');
        $user = $this->account->get(['email', $this->resetPasswordToken->getTokenOwner()]);
        $user->setPassword($newPassword);

        if (!$this->account->update($user)) {
            return redirect('authigniter:resetPasswordResult')->with('reset_password_result', ['type' => 'error', 'message' => lang('AuthIgniter.resetPassword.failed')]);
        }
        $this->resetPasswordToken->delete($resetPasswordToken);
        // send email notification to user if password changed notification has enabled.
        if (in_array('password_changed', $this->config->activeEmailNotifications)) {
            Email::sendPasswordChangedNotification($user);
        }
        return redirect('authigniter:resetPasswordResult')->with('reset_password_result', ['type' => 'success', 'message' => lang('AuthIgniter.resetPassword.success')]);
    }

    public function resetPasswordResult()
    {
        // if user has logged in, redirect to base url
        if ($this->authentication->check()) return redirect()->to(base_url());

        $data['config'] = $this->config;
        
        // grab result type and message from flash data
        $data['type'] = session('reset_password_result.type') ?? 'error';
        $data['message'] = session('reset_password_result.message') ?? lang('AuthIgniter.errorHasOccured');

        return view($this->config->views['reset_password_result'], $data);
    }
}
