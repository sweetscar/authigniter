<?php

namespace SweetScar\AuthIgniter\Libraries\Authorization;

use CodeIgniter\Model;

class BaseAuthorization
{
    protected $config;
    protected $userModel;
    protected $groupModel;
    protected $userGroupModel;
    protected $roleModel;
    protected $userRoleModel;
    protected $error;

    public function __construct($config, Model $userModel, Model $groupModel, Model $userGroupModel, Model $roleModel, Model $userRoleModel)
    {
        $this->config = $config;
        $this->userModel = $userModel;
        $this->groupModel = $groupModel;
        $this->userGroupModel = $userGroupModel;
        $this->roleModel = $roleModel;
        $this->userRoleModel = $userRoleModel;
    }

    public function error(): array|string|null
    {
        return $this->error;
    }
}
