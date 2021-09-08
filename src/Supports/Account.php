<?php

namespace SweetScar\AuthIgniter\Supports;

use SweetScar\AuthIgniter\Models\User;
use SweetScar\AuthIgniter\Models\UserRole;
use SweetScar\AuthIgniter\Supports\Email;
use SweetScar\AuthIgniter\Entities\User as UserEntity;

class Account
{
    public static function get(string $by, string $byValue): UserEntity|null
    {
        $users = new User();

        $allowedByFields = ['id', 'email', 'username'];

        if (in_array($by, $allowedByFields) == false) return null;

        switch ($by) {
            case 'id':
                return $users->find($byValue);
                break;

            case 'email':
                return $users->where('email', $byValue)->first();
                break;

            case 'username':
                return $users->where('username', $byValue)->first();
                break;

            default:
                return null;
                break;
        }
    }

    public static function create(UserEntity $user, string $role = null): UserEntity|bool
    {
        $config = config('AuthIgniter');

        $users = new User();
        $userRoles = new UserRole();

        if ($users->insert($user, false)) {
            if ($role != null) {
                $userRoles->addUserRole($user->id, $role);
            } else {
                $userRoles->addUserRole($user->id, isset($config->defaultUserRole) ? $config->defaultUserRole : 'default');
            }
            if (in_array('registration_success', $config->activeEmailNotifications)) {
                Email::sendRegistrationSuccessNotification($user);
            }
            return $user;
        }
        return false;
    }

    public static function activate(UserEntity $user): bool
    {
        if ($user->isActivated()) return false;

        $user->activate();

        return (new User())->save($user);
    }

    public static function deactivate(UserEntity $user): bool
    {
        if ($user->isActivated() == false) {
            return false;
        }
        $user->deactivate();

        return (new User())->save($user);
    }

    public static function verifyEmail(UserEntity $user): bool
    {
        if ($user->isEmailVerified()) return false;

        $user->verifyEmail();

        return (new User())->save($user);
    }

    public static function update(UserEntity $user): bool
    {
        return (new User())->save($user);
    }
}
