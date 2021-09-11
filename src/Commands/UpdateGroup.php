<?php

namespace SweetScar\AuthIgniter\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class UpdateGroup extends BaseCommand
{
    protected $group = 'AuthIgniter';
    protected $name = 'ai:update_group';
    protected $usage = 'ai:update_group [name]';
    protected $arguments = [
        'name' => "The name of the group to update",
    ];
    protected $description = 'Update a group.';

    public function run(array $params)
    {
        $authorization = service('authorization');

        $name = array_shift($params);
        if (empty($name)) {
            $name = CLI::prompt('Group name to update', null, 'required');
        }

        $group = $authorization->group('name', $name);

        if (is_null($group)) {
            CLI::error($authorization->error(), 'red');
            return;
        }

        $newName = CLI::prompt('Group name', $group->name, 'required|alpha_dash|is_unique[authigniter_groups.name,name,' . $group->name . ']');

        $newDescription = CLI::prompt('Description', $group->description);

        $newGroupData = [
            'name' => $newName,
            'description' => $newDescription
        ];

        if ($authorization->updateGroup($group->id, $newGroupData)) {
            CLI::write('Group "' . $name . '" updated successfully.', 'green');
            $this->call('ai:list_groups');
        } else {
            CLI::error($authorization->error(), 'red');
        }
    }
}
