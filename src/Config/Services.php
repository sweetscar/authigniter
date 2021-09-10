<?php

namespace SweetScar\AuthIgniter\Config;

use CodeIgniter\Model;
use CodeIgniter\Config\BaseService;
use SweetScar\AuthIgniter\Models\User;
use SweetScar\AuthIgniter\Models\Group;
use SweetScar\AuthIgniter\Models\UserGroup;
use SweetScar\AuthIgniter\Models\Role;
use SweetScar\AuthIgniter\Models\UserRole;

class Services extends BaseService
{
    public static function authentication(string $library = 'local', Model $userModel = null, bool $getShared = true)
    {

        if ($getShared) return static::getSharedInstance('authentication', $library, $userModel);

        $config = config('AuthIgniter');
        $class = $config->authenticationLibraries[$library];
        $userModel = $userModel ?? model(User::class);
        $instance = new $class($config, $userModel);

        return $instance;
    }

    public static function authorization(string $library = 'default', Model $userModel = null, Model $groupModel = null, Model $userGroupModel = null, Model $roleModel = null, Model $userRoleModel = null, bool $getShared = true)
    {
        if ($getShared) return static::getSharedInstance('authorization', $library, $userModel, $groupModel, $userGroupModel, $roleModel, $userRoleModel);

        $config = config('AuthIgniter');
        $userModel = $userModel ?? model(User::class);
        $groupModel = $groupModel ?? model(Group::class);
        $userGroupModel = $userGroupModel ?? model(UserGroup::class);
        $roleModel = $roleModel ?? model(Role::class);
        $userRoleModel = $userRoleModel ?? model(UserRole::class);

        $class = $config->authorizationLibraries[$library];
        $instance = new $class($config, $userModel, $groupModel, $userGroupModel, $roleModel, $userRoleModel);

        return $instance;
    }

    public static function account(string $library = 'default', Model $userModel = null, bool $getShared = true)
    {
        if ($getShared) return static::getSharedInstance('account', $library, $userModel);

        $config = config('AuthIgniter');
        $userModel = $userModel ?? model(User::class);
        $class = $config->accountManager[$library];
        $instance = new $class($config, $userModel);

        return $instance;
    }
}
