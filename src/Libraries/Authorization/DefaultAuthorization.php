<?php

namespace SweetScar\AuthIgniter\Libraries\Authorization;

use SweetScar\AuthIgniter\Entities\User;
use SweetScar\AuthIgniter\Libraries\Authorization\AuthorizationInterface;
use SweetScar\AuthIgniter\Models\Role as RoleModel;
use SweetScar\AuthIgniter\Models\User as UserModel;
use SweetScar\AuthIgniter\Models\UserRole as UserRoleModel;

class DefaultAuthorization implements AuthorizationInterface
{
    protected $userModel;
    protected $roleModel;
    protected $userRoleModel;
    protected $error;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->roleModel = new RoleModel();
        $this->userRoleModel = new UserRoleModel();
    }

    public function hasRole(User $user, string $roleName): bool
    {
        $userRole = $this->userRoleModel->where('user_id', $user->id)->first();

        if (is_null($userRole)) {
            return false;
        }

        $role = $this->roleModel->where('name', $roleName)->first();

        if (is_null($role)) {
            return false;
        }

        return ($userRole->role_id == $role->id);
    }

    public function removeUserRole(User $user): bool
    {
        return $this->userRoleModel->where('user_id', $user->id)->delete();
    }

    public function getUserRole(User $user): object|null
    {
        $userRole = $this->userRoleModel->where('user_id', $user->id)->first();

        if (is_null($userRole)) {
            return null;
        }

        $role = $this->roleModel->find($userRole->role_id);

        return $role;
    }

    public function error(): array|string|null
    {
        return $this->error;
    }
}
