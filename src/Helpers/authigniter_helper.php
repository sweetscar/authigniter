<?php

use SweetScar\AuthIgniter\Entities\User;

/**
 * Check if user has logged in
 * 
 * @return bool
 */
if (!function_exists('authenticated')) {
    function authenticated()
    {
        return service('authentication')->check();
    }
}

/**
 * Get current authenticated user
 * 
 * @return User|null
 */
if (!function_exists('user')) {
    function user()
    {
        return service('authentication')->user();
    }
}

/**
 * Check if the user is a member of a grub
 * 
 * @param string $groupName
 */
if (!function_exists('in_group')) {
    function in_group(string $groupName)
    {
        $user = service('authentication')->user();

        if (!$user) return false;

        return service('authorization')->inGroup($user, $groupName);
    }
}
