<?php

namespace SweetScar\AuthIgniter\Libraries\Authorization;

use CodeIgniter\Model;

class BaseAuthorization
{
    protected $config;
    protected $userModel;
    protected $groupModel;
    protected $userGroupModel;
    protected $error;

    public function __construct($config, Model $userModel, Model $groupModel, Model $userGroupModel)
    {
        $this->config = $config;
        $this->userModel = $userModel;
        $this->groupModel = $groupModel;
        $this->userGroupModel = $userGroupModel;
    }

    public function error(): array|string|null
    {
        return $this->error;
    }
}
