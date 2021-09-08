<?php

namespace SweetScar\AuthIgniter\Libraries\Account;

use SweetScar\AuthIgniter\Entities\User;
use SweetScar\AuthIgniter\Supports\Email;
use SweetScar\AuthIgniter\Libraries\Account\AccountInterface;

class DefaultAccountManager implements AccountInterface
{
    protected $config;
    protected $userModel;
    protected $error;

    public function __construct($config, $userModel)
    {
        $this->config = $config;
        $this->userModel = $userModel;
    }

    /**
     * {@inheritdoc}
     */
    public function create(User $user, bool $returnUser = false): User|bool
    {
        if ($this->userModel->insert($user, false)) {
            if (in_array('registration_success', $this->config->activeEmailNotifications)) {
                Email::sendRegistrationSuccessNotification($user);
            }
            return $returnUser ? $user : true;
        }
        $this->error = lang('AuthIgniter.registrationFailed');
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function get(array|string|int $filter): ?User
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function update(User $user): bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(User $user, bool $permanent): bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function activate(User $user): bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deactivate(User $user): bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function verifyEmail(User $user): bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function unverifyEmail(User $user): bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function error(): string
    {
        return $this->error;
    }
}
