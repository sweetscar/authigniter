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

    public function __construct()
    {
        $this->attributes['id'] = uniqid();
    }

    public function setEmail(string $email): User
    {
        $this->attributes['email'] = $email;

        return $this;
    }

    public function setUsername(string $username): User
    {
        $this->attributes['username'] = $username;

        return $this;
    }

    public function setPassword(string $password)
    {
        $this->attributes['password'] = Password::hash($password);

        return $this;
    }

    public function setActive(bool $active): User
    {
        $this->attributes['active'] = (int)$active;

        return $this;
    }

    public function setEmailIsVerified($emailIsVerified): User
    {
        $this->attributes['email_is_verified'] = $emailIsVerified;

        return $this;
    }

    public function activate(): User
    {
        $this->attributes['active'] = 1;

        return $this;
    }

    public function deactivate(): User
    {
        $this->attributes['active'] = 0;

        return $this;
    }

    public function isActivated(): bool
    {
        return isset($this->attributes['active']) && $this->attributes['active'] == true;
    }

    public function verifyEmail(): User
    {
        $this->attributes['email_is_verified'] = 1;

        return $this;
    }

    public function unverifyEmail(): User
    {
        $this->attributes['email_is_verified'] = 0;

        return $this;
    }

    public function isEmailVerified(): bool
    {
        return isset($this->attributes['email_is_verified']) && $this->attributes['email_is_verified'] == true;
    }
}
