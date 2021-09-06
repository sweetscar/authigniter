<?php

namespace SweetScar\AuthIgniter\Config;

use Config\Services as BaseServices;

class Services extends BaseServices
{
    public static function authentication(string $authenticationLibrary = 'local', bool $getShared = true)
    {
        if ($getShared) {
            return self::getSharedInstance('authentication');
        }

        $config = config('AuthIgniter');
        $class = $config->authenticationLibs[$authenticationLibrary];
        $instance = new $class($config);

        return $instance;
    }
}
