<?php

namespace SweetScar\AuthIgniter\Libraries\Authorization;

use SweetScar\AuthIgniter\Entities\User;
use SweetScar\AuthIgniter\Libraries\Authorization\AuthorizationInterface;
use SweetScar\AuthIgniter\Libraries\Authorization\BaseAuthorization;

class DefaultAuthorization extends BaseAuthorization implements AuthorizationInterface
{
    public function group(string $whereField, string|int $fieldValue): array|object|null
    {
        $group = $this->groupModel->where([$whereField => $fieldValue])->first();

        if (!$group) {
            $this->error = lang('AuthIgniter.groupNotFound');
            return null;
        }
        return $group;
    }

    public function groups(): array
    {
        return $this->groupModel->findAll();
    }

    public function createGroup(string $name, ?string $description = null): bool
    {
        if (!$this->groupModel->insert(['name' => $name, 'description' => $description], false)) {
            $this->error = lang('AuthIgniter.failedToCreateGroup');
            return false;
        }
        return true;
    }

    public function updateGroup(int|string $id, array $data): bool
    {
        if (!$this->groupModel->update($id, $data)) {
            $this->error = lang('AuthIgniter.failedToUpdateGroup');
            return false;
        }
        return true;
    }

    public function deleteGroup(int|string|array $id): bool
    {
        if (!$this->groupModel->delete($id)) {
            $this->error = lang('AuthIgniter.failedToDeleteGroup');
            return false;
        }
        return true;
    }

    public function inGroup(User $user, string $groupName): bool
    {
        if (is_null($this->group('name', $groupName))) {
            return false;
        }

        $group = $this->group('name', $groupName);

        $userInGroup = $this->userGroupModel->where([
            'user_id' => $user->id,
            'group_id' => $group->id
        ])->first();

        if (is_null($userInGroup)) {
            $this->error = lang('AuthIgniter.userNotInGroup', [$user->email, $groupName]);
            return false;
        }
        return true;
    }

    public function addUserToGroup(User $user, string $groupName): bool
    {
        $group = $this->groupModel->where('name', $groupName)->first();

        if (is_null($group)) {
            $this->createGroup($groupName);
            $group = $this->groupModel->where('name', $groupName)->first();
        }

        if ($this->inGroup($user, $groupName)) {
            $this->error = lang('AuthIgniter.userAlreadyInGroup', [$user->email, $groupName]);
            return false;
        }

        $addToGroup = $this->userGroupModel->insert([
            'user_id' => $user->id,
            'group_id' => $group->id,
        ], false);

        if (!$addToGroup) {
            $this->error = lang('AuthIgniter.failedToAddUserToGroup');
            return false;
        }
        return true;
    }

    public function removeUserFromGroup(User $user, string $groupName): bool
    {
        $group = $this->group('name', $groupName);

        if (is_null($group)) {
            return false;
        }

        if (!$this->inGroup($user, $groupName)) {
            return false;
        }

        $removeUserFromGroup = $this->userGroupModel->where(['user_id' => $user->id, 'group_id' => $group->id])->delete();

        if (!$removeUserFromGroup) {
            $this->error = lang('AuthIgniter.failedToRemoveUserFromGroup', [$user->email, $group->name]);
            return false;
        }
        return true;
    }

    public function getUserGroups(User $user): array
    {
        $userGroups = $this->userGroupModel->where(['user_id' => $user->id])->findAll();
        $groups = [];
        foreach ($userGroups as $userGroup) {
            $groupItem = $this->groupModel->find($userGroup->group_id);
            array_push($groups, $groupItem->name);
        }

        return $groups;
    }

    ##############################################################################################
    public function listRole(): array
    {
        return $this->roleModel->findAll();
    }

    public function createRole(string $name, ?string $description = null): bool
    {
        return $this->roleModel->insert(['name' => $name, 'description' => $description]);
    }

    public function hasRole(User $user, string $roleName): bool
    {
        $userRole = $this->userRoleModel->where('user_id', $user->id)->first();

        if (is_null($userRole)) {
            $this->error = lang('AuthIgniter.doesNotHaveAnyRoles');
            return false;
        }

        $role = $this->roleModel->where('name', $roleName)->first();

        if (is_null($role)) {
            $this->error = lang('AuthIgniter.noSpesificRole', [$roleName]);
            return false;
        }

        if ($userRole->role_id != $role->id) {
            $this->error = lang('AuthIgniter.doesNotHaveRole', [$roleName]);
            return false;
        }
        return true;
    }

    public function addUserRole(User $user, string $roleName): bool
    {
        $role = $this->roleModel->where('name', $roleName)->first();
        if (is_null($role)) {
            $this->roleModel->insert([
                'name' => $roleName,
                'description' => null,
            ], false);
            $this->addUserRole($user, $roleName);
        }
        if ($this->userRoleModel->where('user_id', $user->id)->first()) {
            $this->error = lang('AuthIgniter.cannotHaveMultipleRole');
            return false;
        }
        if (!$this->userRoleModel->insert([
            'user_id' => $user->id,
            'role_id' => $role->id
        ], false)) {
            $this->error = lang('AuthIgniter.failedToAddUserRole');
            return false;
        }
        return true;
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

    public function roles(): array
    {
        return $this->roleModel->findAll();
    }
}
