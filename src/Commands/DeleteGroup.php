<?php

namespace SweetScar\AuthIgniter\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class DeleteGroup extends BaseCommand
{
    protected $group = 'AuthIgniter';
    protected $name = 'ai:group:delete';
    protected $usage = 'ai:group:create [name]';
    protected $arguments = [
        'name' => "The name of the group to delete",
    ];
    protected $description = 'Delete a group.';

    public function run(array $params)
    {
        $authorization = service('authorization');

        $name = array_shift($params);
        if (empty($name)) {
            $name = CLI::prompt('Group name to delete', null, 'required');
        }

        $group = $authorization->group('name', $name);

        if (is_null($group)) {
            CLI::error($authorization->error(), 'red');
            return;
        }

        if ($authorization->deleteGroup($group->id)) {
            CLI::write('Group "' . $name . '" deleted successfully.', 'green');
        } else {
            CLI::error($authorization->error(), 'red');
        }
    }
}
