<?php

namespace SweetScar\AuthIgniter\Libraries\Email;

class BaseEmail
{
    /**
     * Error string
     * 
     * @var string
     */
    protected $error;

    /**
     * AuthIgniter email config
     */
    protected $emailConfig;

    /**
     * Constructor
     */
    public function __construct($emailConfig = null)
    {
        $this->emailConfig = $emailConfig ?? config('AuthIgniterEmail');
    }

    /**
     * Set error message
     * 
     * @param string $error
     */
    protected function setError(string $error)
    {
        $this->error = $error;
    }

    /**
     * Get error message
     * 
     * @return string
     */
    public function getError(): string
    {
        return $this->error;
    }
}
