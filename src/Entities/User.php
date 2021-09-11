<?php

namespace SweetScar\AuthIgniter\Entities;

use CodeIgniter\Entity\Entity;
use SweetScar\AuthIgniter\Supports\Password;

class User extends Entity
{
    protected $casts = [
        'active' => 'boolean',
        'email_is_verified' => 'boolean'
    ];

    /**
     * Create user id when initialize user.
     */
    public function __construct()
    {
        $this->attributes['id'] = uniqid();
    }

    /**
     * Set user email
     * 
     * @param string $email
     * 
     * @return User
     */
    public function setEmail(string $email): User
    {
        $this->attributes['email'] = $email;

        return $this;
    }

    /**
     * Set user username
     * 
     * @param string $username
     * 
     * @return User
     */
    public function setUsername(string $username): User
    {
        $this->attributes['username'] = $username;

        return $this;
    }

    /**
     * Set user password and hash it automatically
     * 
     * @param string $password
     * 
     * @return User
     */
    public function setPassword(string $password): User
    {
        $this->attributes['password'] = Password::hash($password);

        return $this;
    }

    /**
     * Set user user active status
     * 
     * @param bool $active
     * 
     * @return User
     */
    public function setActive(bool $active): User
    {
        $this->attributes['active'] = (int)$active;

        return $this;
    }

    /**
     * Set user email verified status
     * 
     * @param bool $emailIsVerified
     * 
     * @return User
     */
    public function setEmailIsVerified($emailIsVerified): User
    {
        $this->attributes['email_is_verified'] = $emailIsVerified;

        return $this;
    }

    /**
     * Activate the user
     * 
     * @return User
     */
    public function activate(): User
    {
        $this->attributes['active'] = 1;

        return $this;
    }

    /**
     * Deactivate the user
     * 
     * @return User
     */
    public function deactivate(): User
    {
        $this->attributes['active'] = 0;

        return $this;
    }

    /**
     * Check if user activated
     * 
     * @return bool
     */
    public function isActivated(): bool
    {
        return isset($this->attributes['active']) && $this->attributes['active'] == true;
    }

    /**
     * Verify user email address
     * 
     * @return User
     */
    public function verifyEmail(): User
    {
        $this->attributes['email_is_verified'] = 1;

        return $this;
    }

    /**
     * Unverify user email address
     * 
     * @return User
     */
    public function unverifyEmail(): User
    {
        $this->attributes['email_is_verified'] = 0;

        return $this;
    }

    /**
     * Check if user email is verified
     * 
     * @return bool
     */
    public function isEmailVerified(): bool
    {
        return isset($this->attributes['email_is_verified']) && $this->attributes['email_is_verified'] == true;
    }
}
