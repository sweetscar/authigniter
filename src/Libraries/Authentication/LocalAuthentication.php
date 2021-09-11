<?php

namespace SweetScar\AuthIgniter\Libraries\Authentication;

use Exception;
use CodeIgniter\I18n\Time;
use CodeIgniter\Events\Events;
use SweetScar\AuthIgniter\Entities\User;
use SweetScar\AuthIgniter\Supports\Password;
use SweetScar\AuthIgniter\Libraries\Authentication\AuthenticationInterface;
use SweetScar\AuthIgniter\Libraries\Authentication\BaseAuthentication;

class LocalAuthentication extends BaseAuthentication implements AuthenticationInterface
{
    /**
     * {@inheritdoc}
     */
    public function attempt(array $credentials): bool
    {
        $user = $this->validate($credentials, true);

        if (!$user) {
            $ipAddress = service('request')->getIPAddress();
            $this->recordLoginAttempt(
                $credentials['email'] ?? $credentials['username'],
                null,
                $ipAddress,
                false
            );
            return false;
        }

        if (!$user->isActivated()) {
            $ipAddress = service('request')->getIPAddress();
            $this->recordLoginAttempt(
                $credentials['email'] ?? $credentials['username'],
                $user->id,
                $ipAddress,
                false
            );
            $this->error = lang('AuthIgniter.accountNotActivated');
            return false;
        }

        if ($this->config->requireEmailVerification) {
            if (!$user->isEmailVerified()) {
                $createdAt = Time::parse($user->created_at);
                if ($createdAt->difference(Time::now())->getDays() > $this->config->emailVerificationDeadline) {
                    $this->error = lang('AuthIgniter.unverifiedEmail', [$this->config->emailVerificationDeadline]);
                    return false;
                }
            }
        }

        session()->set('authigniter_logged_in', $user->id);

        $ipAddress = service('request')->getIPAddress();
        $this->recordLoginAttempt(
            $user->email,
            $user->id,
            $ipAddress,
            true
        );

        Events::trigger('user_logged_in', $user);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function check(): bool
    {
        if (session('authigniter_logged_in')) {
            return true;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function validate(array $credentials, bool $returnUser = false): User|bool
    {
        if (empty($credentials['password'])) throw new Exception(lang('AuthIgniter.exception.validateWithoutPassword'), 500);

        $password = $credentials['password'];
        unset($credentials['password']);

        if (count($credentials) > 1) throw new Exception(lang('AuthIgniter.exception.toManyCredential'));

        $user = $this->userModel->where($credentials)->first();

        if (!$user) {
            $this->error = lang('AuthIgniter.badAttempt');
            return false;
        }

        if (!Password::verify($password, $user->password)) {
            $this->error = lang('AuthIgniter.badAttempt');
            return false;
        }

        return $returnUser ? $user : true;
    }

    /**
     * {@inheritdoc}
     */
    public function destroy(): bool
    {
        if (!$this->check()) return false;

        $user = $this->user();

        session()->remove('authigniter_logged_in');

        Events::trigger('user_logged_out', $user);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function user(): ?User
    {
        if (!$this->check()) return null;

        $userId = session('authigniter_logged_in');

        return $this->userModel->find($userId);
    }
}
