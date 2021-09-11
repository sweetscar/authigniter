<?php

namespace SweetScar\AuthIgniter\Libraries\Authorization;

use SweetScar\AuthIgniter\Entities\User;

interface AuthorizationInterface
{
    /**
     * Get detail from a group
     * 
     * @param string $whereField
     * @param string|int $fieldValue
     * 
     * @return array|object|null
     */
    public function group(string $whereField, string|int $fieldValue): array|object|null;

    /**
     * Get all groups
     * 
     * @return array
     */
    public function groups(): array;

    /**
     * Create new group
     * 
     * @param string $name
     * @param string $description
     * 
     * @return bool
     */
    public function createGroup(string $name, string $description = null): bool;

    /**
     * Update a group
     * 
     * @param int|string $id
     * @param array $data
     * 
     * @return bool
     */
    public function updateGroup(int|string $id, array $data): bool;

    /**
     * Delete group
     * 
     * @param int|string|array $id
     * 
     * @return bool
     */
    public function deleteGroup(int|string|array $id): bool;

    /**
     * Checks if the user is in a group.
     * 
     * @param User $user
     * @param string $groupName
     * 
     * @return bool
     */
    public function inGroup(User $user, string $groupName): bool;

    /**
     * Add user to group
     * 
     * @param User $user
     * @param string $groupName
     * 
     * @return bool
     */
    public function addUserToGroup(User $user, string $groupName): bool;

    /**
     * Remove user from group
     * 
     * @param User $user
     * @param string $groupName
     * 
     * @return bool
     */
    public function removeUserFromGroup(User $user, string $groupName): bool;

    /**
     * Get user groups
     * 
     * @param User $user
     * 
     * @return array
     */
    public function getUserGroups(User $user): array;

    /**
     * Returns the latest error string.
     *
     * @return array|string|null
     */
    public function error(): array|string|null;
}
