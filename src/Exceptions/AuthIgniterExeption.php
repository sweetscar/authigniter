<?php

namespace SweetScar\AuthIgniter\Exceptions;

use SweetScar\AuthIgniter\Exceptions\ExceptionInterface;

class AuthIgniterException extends \DomainException implements ExceptionInterface
{
    public static function forValidateWithoutPassword()
    {
        return new self('Cannot validate without password.', 500);
    }
}