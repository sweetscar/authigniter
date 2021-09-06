<?php

namespace SweetScar\AuthIgniter\Libraries\Authentication;

use SweetScar\AuthIgniter\Libraries\Authentication\BaseAuthentication;
use SweetScar\AuthIgniter\Libraries\Authentication\AuthenticationInterface;

class LocalAuthentication extends BaseAuthentication implements AuthenticationInterface
{
    public function attempt(array $credential): bool
    {
        return true;
    }
}
