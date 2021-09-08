<?php

namespace SweetScar\AuthIgniter\Config;

use CodeIgniter\Config\BaseService;
use SweetScar\AuthIgniter\Libraries\Account\DefaultAccountManager;
use SweetScar\AuthIgniter\Libraries\Authorization\DefaultAuthorization;
use SweetScar\AuthIgniter\Models\User;

class Services extends BaseService
{
    public static function authentication(string $library = 'local_authentication', bool $getShared = true)
    {

        if ($getShared) return static::getSharedInstance('authentication', $library);

        $config = config('AuthIgniter');
        $class = $config->authenticationLibraries[$library];
        $instance = new $class($config);

        return $instance;
    }

    public static function authorization(bool $getShared = true)
    {
        if ($getShared) return static::getSharedInstance('authorization');

        return new DefaultAuthorization();
    }

    public static function account(bool $getShared = true)
    {
        if ($getShared) return static::getSharedInstance('account');

        $config = config('AuthIgniter');
        $userModel = new User();
        return new DefaultAccountManager($config, $userModel);
    }
}
