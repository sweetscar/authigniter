<?php

namespace SweetScar\AuthIgniter\Controllers;

use App\Controllers\BaseController;
use SweetScar\AuthIgniter\Entities\User;
use SweetScar\AuthIgniter\Supports\Account;
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

    public function __construct()
    {
        session();
        $this->session = service('session');
        $this->config = config('AuthIgniter');
        $this->validation = service('validation');
        $this->emailVerificationToken = new EmailVerificationToken();
        $this->resetPasswordToken = new ResetPasswordToken();
    }

    public function login()
    {
        $data['config'] = $this->config;

        return view($this->config->views['login'], $data);
    }

    public function attemptLogin()
    {
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

        // start login attempt here
    }

    public function logout()
    {
        # Not Implemented
    }

    public function register()
    {
        $data['config'] = $this->config;

        return view($this->config->views['register'], $data);
    }

    public function attemptRegister()
    {

        $rules = [
            'email' => [
                'label' => lang('AuthIgniter.email'),
                'rules' => 'required|valid_email|is_unique[users.email]'
            ],
            'password' => [
                'label' => lang('AuthIgniter.password'),
                'rules' => 'required|min_length[8]'
            ],
            'repeat-password' => [
                'label' => lang('AuthIgniter.repeatPassword'),
                'rules' => 'required|matches[password]'
            ],
        ];

        if ($this->config->enableUsername) {
            $rules['username'] = [
                'rules' => 'required|min_length[3]|max_length[30]|is_unique[users.username]alpha_numeric'
            ];
        }

        if (!$this->validate($rules)) {
            return redirect('authigniter:register')->withInput()->with('errors', $this->validator->getErrors());
        }

        $user = new User();

        $user->setEmail($this->request->getPost('email'));
        $user->setEmail($this->request->getPost('email'));
        if ($this->config->enableUsername) {
            $user->setUsername($this->request->getPost('username'));
        }
        $user->setPassword($this->request->getPost('password'));
        ($this->config->userActivatedAsDefault) ? $user->activate() : $user->deactivate();
        ($this->config->requireEmailVerification) ? $user->setEmailIsVerified(false) : $user->setEmailIsVerified(true);

        $userAccount = Account::create($user, $this->config->defaultUserRole);

        if ($userAccount) {
            if ($this->config->requireEmailVerification) {
                $token = $this->emailVerificationToken->create($userAccount);
                if ($token) {
                    Email::sendEmailVerificationLink($user->email, $token);
                }
            }
            return redirect('authigniter:login')->with('authigniter_info', lang('AuthIgniter.registrationSuccess'));
        }
        return redirect('authigniter:register')->with('authigniter_error', lang('AuthIgniter.registrationFailed'));
    }

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
                    $verifyUserEmail = Account::verifyEmail(Account::get('email', $email));
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

    public function forgotPassword()
    {
        $data['config'] = $this->config;

        return view($this->config->views['forgot_password'], $data);
    }

    public function attemptForgotPassword()
    {
        $rules = [
            'email' => [
                'rules' => 'required|valid_email'
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect('authigniter:forgotPassword')->withInput()->with('errors', $this->validator->getErrors());
        }

        $email = $this->request->getPost('email');

        $userAccount = Account::get('email', $email);

        if (is_null($userAccount)) {
            return redirect('authigniter:forgotPassword')->withInput()->with('authigniter_error', lang('AuthIgniter.resetPassword.accountNotFound'));
        }

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

    public function resetPassword()
    {
        $token = $this->request->getGet('token');
        $data['config'] = $this->config;
        $data['resetPasswordToken'] = $token;

        if (!$token) {
            return redirect('authigniter:resetPasswordResult')->with('reset_password_result', ['type' => 'error', 'message' => lang('AuthIgniter.resetPassword.linkInvalid')]);
        }

        $verifyToken = $this->resetPasswordToken->verify($token);

        if (!$verifyToken) {
            return redirect('authigniter:resetPasswordResult')->with('reset_password_result', ['type' => 'error', 'message' => $this->resetPasswordToken->getErrorMessage()]);
        }

        return view($this->config->views['reset_password'], $data);
    }

    public function attemptResetPassword($resetPasswordToken)
    {
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

        $verifyToken = $this->resetPasswordToken->verify($resetPasswordToken);

        if (!$verifyToken) {
            return redirect('authigniter:resetPasswordResult')->with('reset_password_result', ['type' => 'error', 'message' => $this->resetPasswordToken->getErrorMessage()]);
        }

        $newPassword = $this->request->getPost('new-password');
        $user = Account::get('email', $this->resetPasswordToken->getTokenOwner());
        $user->setPassword($newPassword);

        if (!Account::update($user)) {
            return redirect('authigniter:resetPasswordResult')->with('reset_password_result', ['type' => 'error', 'message' => lang('AuthIgniter.resetPassword.failed')]);
        }
        $this->resetPasswordToken->delete($resetPasswordToken);
        return redirect('authigniter:resetPasswordResult')->with('reset_password_result', ['type' => 'success', 'message' => lang('AuthIgniter.resetPassword.success')]);
    }

    public function resetPasswordResult()
    {
        $data['config'] = $this->config;
        $data['type'] = session('reset_password_result.type') ?? 'error';
        $data['message'] = session('reset_password_result.message') ?? lang('AuthIgniter.errorHasOccured');

        return view($this->config->views['reset_password_result'], $data);
    }
}
