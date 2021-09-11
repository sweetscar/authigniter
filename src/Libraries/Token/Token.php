<?php

namespace SweetScar\AuthIgniter\Libraries\Token;

use CodeIgniter\I18n\Time;

class Token
{
    /**
     * Error message
     * 
     * @var string
     */
    protected $errorMessage;

    /**
     * Token owner
     * 
     * @var string
     */
    protected $tokenOwner;

    /**
     * Create token
     * 
     * @param int $length
     * 
     * @return string
     */
    protected function createToken(int $length = 16): string
    {
        return bin2hex(openssl_random_pseudo_bytes($length));
    }

    /**
     * Check if token is expired or not
     * 
     * @param string $createdAt
     * @param string $tokenType
     * 
     * @return bool
     */
    protected function isTokenExpired($createdAt, string $tokenType): bool
    {
        $config = config('AuthIgniter');

        $createdAt = Time::parse($createdAt);

        if ($createdAt->difference(Time::now())->getSeconds() > $config->tokenExpiryTime[$tokenType]) return true;

        return false;
    }

    /**
     * Set error message
     * 
     * @param string $errorMessage
     */
    protected function setErrorMessage(string $errorMessage)
    {
        $this->errorMessage = $errorMessage;

        return $this;
    }

    /**
     * Get error message
     * 
     * @return string
     */
    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    /**
     * Set owner of token
     * 
     * @param string $tokenOwner Email of user that have token
     */
    protected function setTokenOwner(string $tokenOwner)
    {
        $this->tokenOwner = $tokenOwner;

        return $this;
    }

    /**
     * Get token owner
     * 
     * @return string
     */
    public function getTokenOwner(): string
    {
        return $this->tokenOwner;
    }
}
