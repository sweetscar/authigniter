<?php

namespace SweetScar\AuthIgniter\Libraries\Account;

use SweetScar\AuthIgniter\Entities\User;

interface AccountInterface
{
    /**
     * Creating New User Account.
     * 
     * By default we create a new user account using this method. 
     * You can create an account directly using the user model, 
     * but we still recommend using this method as creating 
     * an account will also perform some additional logic
     * like sending email notifications or
     * email verification links to new users.
     * 
     * @param User $user
     * @param bool $returnUser
     * 
     * @return User|bool
     */
    public function create(User $user, bool $returnUser = false): User|bool;

    /**
     * Getting User Account
     * 
     * This method is used to retrieve a specific user account from the database.
     * If you pass a string or integer value in the parameter, 
     * this method will treat it as the primary key to look up the user account.
     * If you pass an associative array value in the parameter,
     * this method will treat the array key as the column name in the users table 
     * and the array value as the value used to look up the user account.
     * 
     * @param array|string|int $filter
     * 
     * @return User|null
     */
    public function get(array|string|int $filter): User|null;

    /**
     * Updating user account
     * 
     * @param User $user
     * 
     * @return bool
     */
    public function update(User $user): bool;

    /**
     * Deleting user account
     * 
     * @param User $user
     * @param bool $permanent
     * 
     * @return bool
     */
    public function delete(User $user, bool $permanent): bool;

    /**
     * Activate user account.
     * 
     * @param User
     * 
     * @return bool
     */
    public function activate(User $user): bool;

    /**
     * Deactivate user account.
     * 
     * @param User
     * 
     * @return bool
     */
    public function deactivate(User $user): bool;

    /**
     * Verify user email address.
     * 
     * @param User $user
     * 
     * @return bool
     */
    public function verifyEmail(User $user): bool;

    /**
     * Unverify user email address.
     * 
     * @param User $user
     * 
     * @return bool
     */
    public function unverifyEmail(User $user): bool;

    /**
     * Returns last error message.
     * 
     * @return string
     */
    public function error(): string;
}
