<?php

namespace SweetScar\AuthIgniter\Supports;

class Password
{
    public static function hash(string $password): string
    {
        $config = config('AuthIgniter');
        return password_hash(self::preparePassword($password), $config->hashAlgorithm);
    }

    public static function verify(string $password, string $hash): bool
    {
        return password_verify(self::preparePassword($password), $hash);
    }

    protected static function preparePassword(string $password): string
    {
        return base64_encode(hash('sha384', $password, true));
    }
}
