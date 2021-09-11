<?php

namespace SweetScar\AuthIgniter\Libraries\Email;

class Email
{
    protected $fromEmail;
    protected $fromName;
    protected $toEmail;
    protected $toName;
    protected $subject;
    protected $content;
    protected $error;
    protected $library;
    protected $config;

    public function __construct(string $library = null)
    {
        $this->config = config('AuthIgniter');

        if ($library == null) {
            $this->library = $this->config->defaultEmailLibrary;
        } else {
            $this->library = $library;
        }
    }

    public function setFromEmail(string $fromEmail)
    {
        $this->fromEmail = $fromEmail;
    }

    public function setFromName(string $fromName)
    {
        $this->fromName = $fromName;
    }

    public function setToName(string $toName)
    {
        $this->toName = $toName;
    }

    public function setToEmail(string $toEmail)
    {
        $this->toEmail = $toEmail;
    }

    public function setSubject(string $subject)
    {
        $this->subject = $subject;
    }

    public function setContent(string $content)
    {
        $this->content = $content;
    }

    protected function setError(string $error)
    {
        $this->error = $error;
    }

    public function getError()
    {
        return $this->error;
    }

    protected function validate(): bool
    {
        $availableLibraries = array_keys($this->config->emailLibraries);

        if (!in_array($this->library, $availableLibraries)) {
            $this->setError('Library tidak ada dalam daftar');
            return false;
        }
        if (!$this->fromEmail) {
            $this->setError('From email harus di atur dulu');
            return false;
        }
        if (!filter_var($this->fromEmail)) {
            $this->setError('From email harus alamat email yang valid');
            return false;
        }
        if (!$this->toEmail) {
            $this->setError('To email harus di atur dulu');
            return false;
        }
        if (!filter_var($this->toEmail)) {
            $this->setError('To email harus alamat email yang valid');
            return false;
        }
        if (!$this->subject) {
            $this->setError('Subjek harus di atur dulu');
            return false;
        }
        if (!$this->content) {
            $this->setError('Content harus di atur dulu');
            return false;
        }

        return true;
    }

    public function send(): bool
    {
        $library = $this->config->emailLibraries[$this->library];
        $emaiConfig = config('AuthIgniterEmail');
        $email = new $library($emaiConfig);

        $emailSent = $email->send(
            $this->fromEmail,
            $this->fromName,
            $this->toEmail,
            $this->toName,
            $this->subject,
            $this->content,
        );

        if (!$emailSent) {
            $this->setError($email->getError());
            return false;
        }
        return true;
    }
}
