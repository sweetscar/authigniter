<?php

namespace SweetScar\AuthIgniter\Libraries\Authentication;

use CodeIgniter\Events;
use CodeIgniter\Model;
use SweetScar\AuthIgniter\Config\AuthIgniter as AuthConfig;
use SweetScar\AuthIgniter\Entities\User;

class BaseAuthentication
{
    protected $user;
    protected $config;
    protected $error;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function error()
    {
        return $this->error;
    }

    public function login(User $user = null): bool
    {
        if (empty($user)) {
            $this->user = null;
            return false;
        }

        $this->user = $user;

        $ipAddress = service('request')->getIPAddress();

        if (ENVIRONMENT !== 'testing') {
            session()->regenerate();
        }

        session()->set('logged_in', $this->user->id);

        return true;
    }

    public function user()
    {
        return $this->user;
    }
}
