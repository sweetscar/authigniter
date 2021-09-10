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
    public function get(array|string|int $filter): ?User;

    /**
     * Updating user account
     * 
     * This method is used to updating a spesific user account.
     * The instance of the user entity is passed to the parameter
     * as the account to be updated and ready to save.
     * 
     * @param User $user
     * 
     * @return bool
     */
    public function update(User $user): bool;

    /**
     * Deleting user account
     * 
     * This method performs soft delete to the specific user account passed in the first parameter.
     * If you provide true in the second parameter, this method will permanently delete the account in the database.
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
     * This method is a shorthand to change the user's active status to activated.
     * You can also do the same thing by changing the active state of the user
     * instance and then saving it using the update method.
     * 
     * @param User
     * 
     * @return bool
     */
    public function activate(User $user): bool;

    /**
     * Deactivate user account.
     * 
     * This method is a shorthand to change the user's active status to deactivated.
     * You can also do the same thing by changing the active state of the user
     * instance and then saving it using the update method.
     * 
     * @param User
     * 
     * @return bool
     */
    public function deactivate(User $user): bool;

    /**
     * Verify user email address.
     * 
     * This method is a shorthand to change the user's email to verified.
     * You can also do the same thing by changing the is_email_verified state of the user
     * instance and then saving it using the update method.
     * 
     * @param User $user
     * 
     * @return bool
     */
    public function verifyEmail(User $user): bool;

    /**
     * Unverify user email address.
     * 
     * This method is a shorthand to change the user's email to unverified.
     * You can also do the same thing by changing the is_email_verified state of the user
     * instance and then saving it using the update method.
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
