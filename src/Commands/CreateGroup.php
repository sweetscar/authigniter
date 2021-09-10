<?php

namespace SweetScar\AuthIgniter\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class CreateGroup extends BaseCommand
{
    protected $group = 'AuthIgniter';
    protected $name = 'ai:group:create';
    protected $usage = 'ai:group:create [name] [description]';
    protected $arguments = [
        'name' => "The name of the new group to create",
        'description' => "Optional description 'in quotes'",
    ];
    protected $description = 'Create new group.';

    public function run(array $params)
    {
        $authorization = service('authorization');

        $name = array_shift($params);
        if (empty($name)) {
            $name = CLI::prompt('Group name', null, 'required|alpha_dash|is_unique[authigniter_groups.name]');
        }

        $description = array_shift($params);
        if (empty($description)) {
            $description = CLI::prompt('Description', '');
        }

        if ($authorization->createGroup($name, $description)) {
            CLI::write('Group "' . $name . '" created successfully.', 'green');
            CLI::write('');
            $this->call('ai:group:list');
        } else {
            CLI::error($authorization->error(), 'red');
        }
    }
}
