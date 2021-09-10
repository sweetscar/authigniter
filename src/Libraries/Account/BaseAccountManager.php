<?php

namespace SweetScar\AuthIgniter\Libraries\Account;

class BaseAccountManager
{
    protected $config;
    protected $userModel;
    protected $error;

    public function __construct($config, $userModel)
    {
        $this->config = $config;
        $this->userModel = $userModel;
    }

    /**
     * {@inheritdoc}
     */
    public function error(): string
    {
        return $this->error;
    }
}
