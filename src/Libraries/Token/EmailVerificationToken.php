<?php

namespace SweetScar\AuthIgniter\Libraries\Token;

use SweetScar\AuthIgniter\Entities\User;
use SweetScar\AuthIgniter\Libraries\Token\Token;
use SweetScar\AuthIgniter\Models\EmailVerificationToken as Model;

class EmailVerificationToken extends Token
{
    protected $model;

    public function __construct()
    {
        $this->model = new Model();
    }

    /**
     * Create email verification token
     * 
     * @param User $user
     * 
     * @return null|string
     */
    public function create(User $user): null|string
    {
        $token = $this->createToken(32);

        $saved = $this->model->insert([
            'email' => $user->email,
            'token' => $token
        ], false);
        if ($saved) {
            return $token;
        }
        return null;
    }

    /**
     * Verify email verification token
     * 
     * @param string $token
     * 
     * @return bool
     */
    public function verify(string $token): bool
    {
        $verificationToken = $this->model->where('token', $token)->first();

        if (is_null($verificationToken)) {
            $this->setErrorMessage(lang('AuthIgniter.emailVerification.linkInvalid'));
            return false;
        }

        if ($this->isTokenExpired($verificationToken->created_at, 'email_verification')) {
            $this->setErrorMessage(lang('AuthIgniter.emailVerification.linkExpired'));
            $this->delete($verificationToken->token);
            return false;
        }

        $this->setTokenOwner($verificationToken->email);
        $this->delete($verificationToken->token);
        return true;
    }

    /**
     * Delete email verification token
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
