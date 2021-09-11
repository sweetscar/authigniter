<?php

namespace SweetScar\AuthIgniter\Libraries\Account;

use CodeIgniter\Events\Events;
use Error;
use SweetScar\AuthIgniter\Entities\User;
use SweetScar\AuthIgniter\Supports\Email;
use SweetScar\AuthIgniter\Libraries\Account\AccountInterface;
use SweetScar\AuthIgniter\Libraries\Account\BaseAccountManager;

class DefaultAccountManager extends BaseAccountManager implements AccountInterface
{
    /**
     * {@inheritdoc}
     */
    public function all(?array $filter = null): array
    {
        if (is_null($filter)) {
            return $this->userModel->findAll();
        }

        return $this->userModel->where($filter)->findAll();
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
            Events::trigger('user_created', $user);
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
        if (is_string($filter) || is_int($filter)) {
            $userAccount = $this->userModel->find($filter);
            if (!$userAccount) {
                $this->error = lang('AuthIgniter.cannotFindUserAccount');
                return null;
            }
            return $userAccount;
        }
        if (is_array($filter)) {
            $validFilterFields = ['id', 'email', 'username'];
            if (array_intersect($validFilterFields, array_keys($filter)) == []) {
                throw new Error();
            }
            $userAccount = $this->userModel->where($filter)->first();
            if (!$userAccount) {
                $this->error = lang('AuthIgniter.cannotFindUserAccount');
                return null;
            }
            return $userAccount;
        }
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function update(User $user): bool
    {
        if (!$this->userModel->save($user)) {
            $this->error = lang('AuthIgniter.failedToUpdateAccount');
            return false;
        }
        Events::trigger('user_updated', $user);
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(User $user, bool $permanent): bool
    {
        $authorization = service('authorization');

        $userGroups = $authorization->getUserGroups($user);

        if (!$this->userModel->delete($user->id, $permanent)) {
            $this->error = lang('AuthIgniter.failedToDeleteAccount');
            return false;
        }
        if ($permanent) {
            Events::trigger('user_deleted_permanently', $user);
            foreach ($userGroups as $group) {
                $authorization->removeUserFromGroup($user, $group);
            }
        } else {
            Events::trigger('user_deleted', $user);
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function activate(User $user): bool
    {
        if ($user->isActivated()) {
            $this->error = lang('AuthIgniter.accountAlreadyActivated');
            return false;
        }

        $user->activate();

        if (!$this->userModel->save($user)) {
            $this->error = lang('AuthIgniter.failedToActivateAccount');
            return false;
        }
        Events::trigger('user_activated', $user);
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deactivate(User $user): bool
    {
        if (!$user->isActivated()) {
            $this->error = lang('AuthIgniter.accountCurrentlyInactive');
            return false;
        }

        $user->deactivate();

        if (!$this->userModel->save($user)) {
            $this->error = lang('AuthIgniter.failedToDeactivateAccount');
            return false;
        }
        Events::trigger('user_deactivated', $user);
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function verifyEmail(User $user): bool
    {
        if ($user->isEmailVerified()) {
            $this->error = lang('AuthIgniter.emailHasBeenVerified');
            return false;
        }

        $user->verifyEmail();

        if (!$this->userModel->save($user)) {
            $this->error = lang('AuthIgniter.failedToVerifyEmail');
            return false;
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function unverifyEmail(User $user): bool
    {
        if (!$user->isEmailVerified()) {
            $this->error = lang('AuthIgniter.emailCurrentlyNotVerified');
            return false;
        }

        $user->verifyEmail();

        if (!$this->userModel->save($user)) {
            $this->error = lang('AuthIgniter.failedToUnverifyEmail');
            return false;
        }
        return true;
    }
}
