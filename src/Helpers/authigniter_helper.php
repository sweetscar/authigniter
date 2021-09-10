<?php

if (!function_exists('authenticated')) {
    function authenticated()
    {
        return service('authentication')->check();
    }
}

if (!function_exists('user')) {
    function user()
    {
        return service('authentication')->user();
    }
}

if (!function_exists('has_role')) {
    function has_role(string $roleName)
    {
        $user = service('authentication')->user();

        if (!$user) return false;

        return service('authorization')->hasRole($user, $roleName);
    }
}
