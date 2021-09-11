<?php

namespace SweetScar\AuthIgniter\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class ListUserGroups extends BaseCommand
{
    protected $group = 'AuthIgniter';
    protected $name = 'ai:list_user_groups';
    protected $usage = 'ai:list_user_groups [identifier]';
    protected $arguments = [
        'identifier' => "Email or username of user account.",
    ];
    protected $description = 'Show group list of user.';

    public function run(array $params)
    {
        $account = service('account');

        $identifier = array_shift($params);
        if (empty($identifier)) {
            $identifier = CLI::prompt('Identifier (email or username)', null, 'required');
        }

        $type = (filter_var($identifier, FILTER_VALIDATE_EMAIL)) ? 'email' : 'username';

        $user = $account->get([$type => $identifier]);

        if (!$user) {
            CLI::error('User ' . $identifier . ' not found.');
            return;
        }

        $userGroups = service('authorization')->getUserGroups($user);

        $body = [];

        foreach ($userGroups as $index => $group) {
            array_push($body, [++$index, $group]);
        }

        CLI::table($body, ['No', 'Group name']);
    }
}
