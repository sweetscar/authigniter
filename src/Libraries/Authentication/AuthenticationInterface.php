<?php

namespace SweetScar\AuthIgniter\Libraries\Authentication;

use SweetScar\AuthIgniter\Entities\User;

interface AuthenticationInterface
{
    /**
     * Attempts to validate the credentials and log a user in.
     *
     * @param array $credentials
     *
     * @return bool
     */
    public function attempt(array $credentials): bool;

    /**
     * Checks to see if the user is logged in or not.
     *
     * @return bool
     */
    public function check(): bool;

    /**
     * Checks the user's credentials to see if they could authenticate.
     * Unlike `attempt()`, will not log the user into the system.
     *
     * @param array $credentials
     * @param bool  $returnUser
     *
     * @return User|bool
     */
    public function validate(array $credentials, bool $returnUser = false): User|bool;

    /**
     * Destroy current authenticated user.
     * a.k.a logout.
     * 
     * @return bool
     */
    public function destroy(): bool;

    /**
     * Returns the User instance for the current logged in user.
     *
     * @return User|null
     */
    public function user(): User|null;

    /**
     * Returns the last error message text.
     * 
     * @return string
     */
    public function error(): string;
}
