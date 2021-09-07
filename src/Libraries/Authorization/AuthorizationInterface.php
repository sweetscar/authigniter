<?php

namespace SweetScar\AuthIgniter\Libraries\Authorization;

use SweetScar\AuthIgniter\Entities\User;

interface AuthorizationInterface
{
    /**
     * Check if user has spesific role.
     * 
     * @param User $user An instance of user
     * @param string $roleName Role name
     * 
     * @return bool
     */
    public function hasRole(User $user, string $roleName): bool;

    /**
     * Remove user role.
     * 
     * @param User $user An instance of user
     * 
     * @return bool
     */
    public function removeUserRole(User $user): bool;

    /**
     * Get user role
     * 
     * @param User $user An instance of user
     * 
     * @return object|null
     */
    public function getUserRole(User $user): object|null;

    /**
     * Returns the latest error string.
     *
     * @return array|string|null
     */
    public function error(): array|string|null;
}
