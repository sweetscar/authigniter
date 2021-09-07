<?php

namespace SweetScar\AuthIgniter\Libraries\Token;

use CodeIgniter\I18n\Time;

class Token
{
    protected $errorMessage;
    protected $tokenOwner;

    protected function createToken(int $length = 16): string
    {
        return bin2hex(openssl_random_pseudo_bytes($length));
    }

    protected function isTokenExpired($createdAt, string $tokenType): bool
    {
        $config = config('AuthIgniter');

        $createdAt = Time::parse($createdAt);

        if ($createdAt->difference(Time::now())->getSeconds() > $config->tokenExpiryTime[$tokenType]) return true;

        return false;
    }

    protected function setErrorMessage(string $errorMessage)
    {
        $this->errorMessage = $errorMessage;

        return $this;
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    protected function setTokenOwner(string $tokenOwner)
    {
        $this->tokenOwner = $tokenOwner;

        return $this;
    }

    public function getTokenOwner(): string
    {
        return $this->tokenOwner;
    }
}
