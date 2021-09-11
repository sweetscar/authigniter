<?php

namespace SweetScar\AuthIgniter\Libraries\Token;

use SweetScar\AuthIgniter\Libraries\Token\Token;
use SweetScar\AuthIgniter\Models\ResetPasswordToken as Model;

class ResetPasswordToken extends Token
{
    protected $model;

    public function __construct()
    {
        $this->model = new Model();
    }

    /**
     * Create reset password token
     * 
     * @param string $email
     * @param string $ipAddress
     * @param string $userAgent
     * 
     * @return bool|string
     */
    public function create(string $email, string $ipAddress, string $userAgent): bool|string
    {
        $token = $this->createToken(32);

        $saved = $this->model->insert([
            'email' => $email,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'token' => $token
        ], false);
        if ($saved) {
            return $token;
        }
        return false;
    }

    /**
     * Verify reset password token
     * 
     * @param string $token
     * 
     * @return bool
     */
    public function verify(string $token): bool
    {
        $resetToken = $this->model->where('token', $token)->first();

        if (is_null($resetToken)) {
            $this->setErrorMessage(lang('AuthIgniter.resetPassword.linkInvalid'));
            return false;
        }

        if ($this->isTokenExpired($resetToken->created_at, 'reset_password')) {
            $this->setErrorMessage(lang('AuthIgniter.resetPassword.linkExpired'));
            $this->model->delete($resetToken->id);
            return false;
        }

        $this->setTokenOwner($resetToken->email);
        return true;
    }

    /**
     * Delete reset password token
     * 
     * @param string $token
     * 
     * @return bool
     */
    public function delete(string $token): bool
    {
        $resetToken = $this->model->where('token', $token)->first();

        return $this->model->delete($resetToken->id);
    }
}
