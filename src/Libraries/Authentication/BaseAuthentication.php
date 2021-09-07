<?php

namespace SweetScar\AuthIgniter\Libraries\Authentication;

use SweetScar\AuthIgniter\Models\User as UserModel;
use SweetScar\AuthIgniter\Models\Login as LoginModel;

class BaseAuthentication
{
    protected $error;
    protected $config;
    protected $loginModel;
    protected $userModel;

    public function __construct($config)
    {
        $this->config = $config;
        $this->userModel = new UserModel();
        $this->loginModel = new LoginModel();
    }

    public function error(): string
    {
        return $this->error;
    }

    protected function recordLoginAttempt(string $login, string $userId = null, string $ipAddress = null, bool $success)
    {
        return $this->loginModel->insert([
            'login' => $login,
            'user_id' => $userId,
            'ip_address' => $ipAddress,
            'success' => (int)$success
        ]);
    }
}
