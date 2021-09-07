<?php

namespace SweetScar\AuthIgniter\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use SweetScar\AuthIgniter\Supports\Role as RoleSupport;

class Role extends BaseCommand
{
    protected $group = 'Authigniter';
    protected $name = 'authigniter:role';
    protected $usage = 'authigniter:role [argument]';
    protected $arguments = [
        'list' => 'List all role item.',
        'create' => 'Create new role item.',
        'delete' => 'Delete role item.'
    ];
    protected $description = 'Manage AuthIgniter Role.';

    public function run(array $params)
    {
        $availableOperations = ['list', 'create', 'delete'];
        if (empty($params)) {
            $operation = CLI::prompt('What operation would you like to perform on the role? ', $availableOperations, 'required');
        } else {
            $operation = $params[0];
        }
        $this->$operation();
    }

    private function list()
    {
        $roles = RoleSupport::list();
        $body = [];
        foreach ($roles as $role) {
            array_push($body, [$role->id, $role->name, $role->description]);
        }
        $head = ['id', 'name', 'description'];
        CLI::table($body, $head);
    }

    private function create()
    {
        $roleName = $this->newRoleName();
        $roleDescription = $this->newRoleDescription();

        $role = RoleSupport::create($roleName, $roleDescription);

        if (!$role) return CLI::error('Failed to create role item, please try again.');

        return CLI::write('Role ' . $role->name . ' created successfully.', 'green');
    }

    private function delete()
    {
        $roles = RoleSupport::list();

        if (empty($roles)) return CLI::write('Nothing to delete, role table is empty');

        CLI::write('What role do you want to delete?');
        $this->list();
        $roleId = CLI::prompt('Please enter the id of the role you want to delete! (type * to delete all role)', null, 'required');

        if ($roleId == '*') {
            if (!RoleSupport::deleteAll()) {
                return CLI::error('Failed to delete the role.');
            }
            return CLI::write('All role deleted successfully', 'green');
        }
        if (!RoleSupport::delete('id', $roleId)) {
            return CLI::error('Failed to delete the role.');
        }

        return CLI::write('Role deleted successfully.', 'green');
    }

    private function newRoleName()
    {
        $roleName = CLI::prompt('New role name? ', null, 'required|alpha_dash');
        if (RoleSupport::get('name', $roleName)) {
            CLI::error('Role name already used, please choose another role name.');
            $this->newRoleName();
        } else {
            return $roleName;
        }
    }

    private function newRoleDescription()
    {
        $roleDescription = CLI::prompt('New role description? ', null, 'max_length[255]');

        return $roleDescription;
    }
}
