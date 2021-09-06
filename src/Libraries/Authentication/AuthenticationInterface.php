<?php

namespace SweetScar\AuthIgniter\Libraries\Authentication;

interface AuthenticationInterface
{
    public function attempt(array $credentials): bool;
}