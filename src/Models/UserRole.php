<?php

namespace SweetScar\AuthIgniter\Models;

use CodeIgniter\Model;
use SweetScar\AuthIgniter\Models\Role;

class UserRole extends Model
{
    protected $table = 'authigniter_user_roles';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['user_id', 'role_id'];
    protected $useTimestamps = false;

    public function addUserRole(string $userId, string $roleName): bool
    {
        $roles = new Role();

        $role = $roles->where('name', $roleName)->first();

        if (is_null($role)) {
            $roleId = $roles->insert(['name' => $roleName], true);
        } else {
            $roleId = $role->id;
        }

        if (!$this->where('user_id', $userId)->first()) {
            return $this->insert([
                'role_id' => $roleId,
                'user_id' => $userId
            ], false);
        }

        return false;
    }

    public function deleteAll()
    {
        return $this->builder->emptyTable();
    }
}
