<?php

namespace SweetScar\AuthIgniter\Supports;

use SweetScar\AuthIgniter\Models\Role as RoleModel;
use SweetScar\AuthIgniter\Models\UserRole as UserRoleModel;

class Role
{
    public static function create(string $roleName, string|null $description = null): bool|object
    {
        $roles = new RoleModel();
        if ($roles->where('name', $roleName)->first()) return false;
        if (!$roles->insert(['name' => $roleName, 'description' => $description], false)) return false;

        $savedRole =  $roles->where('name', $roleName)->first();

        if (!$savedRole) return false;
        return $savedRole;
    }

    public static function get(string $by, string $byValue): null|object
    {
        $allowedByFields = ['id', 'name'];

        if (in_array($by, $allowedByFields) == false) return null;

        $roles = new RoleModel();
        return $roles->where($by, $byValue)->first();
    }

    public static function list()
    {
        $roles = new RoleModel();
        return $roles->findAll();
    }

    public static function delete(string $by, string $byValue)
    {
        $allowedByFields = ['id', 'name'];

        if (in_array($by, $allowedByFields) == false) return false;

        $roles = new RoleModel();
        $userRole = new UserRoleModel();

        $role = $roles->where($by, $byValue)->first();

        if (!$role) return false;

        if (!$roles->delete($role->id)) return false;

        $userRole->where('role_id', $role->id)->delete();

        return true;
    }

    public static function deleteAll()
    {
        $roles = new RoleModel();
        $userRole = new UserRoleModel();

        if (!$roles->deleteAll()) return false;
        $userRole->deleteAll();
        return true;
    }
}
