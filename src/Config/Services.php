<?php

namespace SweetScar\AuthIgniter\Config;

use CodeIgniter\Model;
use CodeIgniter\Config\BaseService;
use SweetScar\AuthIgniter\Models\User;
use SweetScar\AuthIgniter\Models\Group;
use SweetScar\AuthIgniter\Models\UserGroup;

class Services extends BaseService
{
    /**
     * Authentication Service
     * 
     * Provides services to manage all logic related to authentication.
     * 
     * @param string $library
     * @param Model $userModel
     * @param bool $getShared
     */
    public static function authentication(string $library = 'local', Model $userModel = null, bool $getShared = true)
    {

        if ($getShared) return static::getSharedInstance('authentication', $library, $userModel);

        $config = config('AuthIgniter');
        $class = $config->authenticationLibraries[$library];
        $userModel = $userModel ?? model(User::class);
        $instance = new $class($config, $userModel);

        return $instance;
    }

    /**
     * Authorization Service
     * 
     * Provides services to manage all logic related to authorization.
     * 
     * @param string $library
     * @param Model $userModel
     * @param Model $groupModel
     * @param Model $userGroupModel
     * @param bool $getShared
     */
    public static function authorization(string $library = 'default', Model $userModel = null, Model $groupModel = null, Model $userGroupModel = null, bool $getShared = true)
    {
        if ($getShared) return static::getSharedInstance('authorization', $library, $userModel, $groupModel, $userGroupModel);

        $config = config('AuthIgniter');
        $userModel = $userModel ?? model(User::class);
        $groupModel = $groupModel ?? model(Group::class);
        $userGroupModel = $userGroupModel ?? model(UserGroup::class);

        $class = $config->authorizationLibraries[$library];
        $instance = new $class($config, $userModel, $groupModel, $userGroupModel);

        return $instance;
    }

    /**
     * Account Service
     * 
     * Provides services to manage all logic related to user account.
     * 
     * @param string $library
     * @param Model $userModel
     * @param bool $getShared
     */
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
