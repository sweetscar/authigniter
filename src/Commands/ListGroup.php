<?php

namespace SweetScar\AuthIgniter\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class ListGroup extends BaseCommand
{
    protected $group = 'AuthIgniter';
    protected $name = 'ai:list_groups';
    protected $usage = 'ai:list_groups';
    protected $description = 'Show all group.';

    public function run(array $params)
    {
        $authorization = service('authorization');

        $groups = $authorization->groups();

        $body = [];

        foreach ($groups as $group) {
            array_push($body, [$group->id, $group->name, $group->description, $group->created_at, $group->updated_at]);
        }
        $head = ['id', 'name', 'description', 'created_at', 'updated_at'];
        CLI::table($body, $head);
    }
}
