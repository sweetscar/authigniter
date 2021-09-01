<?php

namespace SweetScar\AuthIgniter\Controllers;

use App\Controllers\BaseController;


class AuthIgniter extends BaseController
{
    protected $config;
    protected $session;

    public function __construct()
    {
        $this->session = service('session');
        $this->config = config('AuthIgniter');
    }

    public function login()
    {
        return view($this->config->views['login'], ['config' => $this->config]);
    }

    public function attemptLogin()
    {
        d($this->request->getPost());
    }

    public function logout()
    {
        # Not Implemented
    }

    public function register()
    {
        return view($this->config->views['register'], ['config' => $this->config]);
    }

    public function attemptRegister()
    {
        d($this->request->getPost());
    }

    public function forgotPassword()
    {
        return view($this->config->views['forgot_password'], ['config' => $this->config]);
    }

    public function attemptForgotPassword()
    {
        d($this->request->getPost());
    }

    public function resetPassword()
    {
        # Not Implemented
    }

    public function attemptResetPassword()
    {
        # Not Implemented
    }

    public function verifyEmail()
    {
        # Not Implemented
    }
}
