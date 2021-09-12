<?php

namespace SweetScar\AuthIgniter\Supports;

class Password
{
    /**
     * Hash the password
     * 
     * @param string $password
     * 
     * @return string
     */
    public static function hash(string $password): string
    {
        $config = config('AuthIgniter');
        return password_hash(self::preparePassword($password), $config->hashAlgorithm);
    }

    /**
     * Verify hashed password
     * 
     * @param string $password
     * @param string hash
     * 
     * @return bool
     */
    public static function verify(string $password, string $hash): bool
    {
        return password_verify(self::preparePassword($password), $hash);
    }

    /**
     * Prepare the password
     * 
     * @param string $password
     * 
     * @return string
     */
    protected static function preparePassword(string $password): string
    {
        return base64_encode(hash('sha384', $password, true));
    }
}
