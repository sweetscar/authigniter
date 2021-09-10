<?php

namespace SweetScar\AuthIgniter\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class ListGroup extends BaseCommand
{
    protected $group = 'AuthIgniter';
    protected $name = 'ai:group:list';
    protected $usage = 'ai:group:list';
    protected $description = 'Show all group.';

    public function run(array $params)
    {
        $authorization = service('authorization');

        $groups = $authorization->groups();

        $body = [];
        
        foreach ($groups as $group) {
            array_push($body, [$group->id, $group->name, $group->description]);
        }
        $head = ['id', 'name', 'description'];
        CLI::table($body, $head);
    }
}
