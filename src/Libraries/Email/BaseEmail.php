<?php

namespace SweetScar\AuthIgniter\Libraries\Email;

class BaseEmail
{
    protected $error;

    protected function setError(string $error)
    {
        $this->error = $error;
    }

    public function getError(): string
    {
        return $this->error;
    }
}
