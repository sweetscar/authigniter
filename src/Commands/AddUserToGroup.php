<?php

namespace SweetScar\AuthIgniter\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class AddUserToGroup extends BaseCommand
{
    protected $group = 'AuthIgniter';
    protected $name = 'ai:user:add_to_group';
    protected $usage = 'ai:user:add_to_group [identifier] [group]';
    protected $arguments = [
        'identifier' => "Email or username of user account.",
        'group' => "Group name where user to be added.",
    ];
    protected $description = 'Add user to group.';

    public function run(array $params)
    {
        $account = service('account');
        $authorization = service('authorization');

        $identifier = array_shift($params);
        if (empty($identifier)) {
            $identifier = CLI::prompt('Identifier (email or username)', null, 'required');
        }

        $group = array_shift($params);
        if (empty($group)) {
            $group = CLI::prompt('Group', '');
        }

        $type = (filter_var($identifier, FILTER_VALIDATE_EMAIL)) ? 'email' : 'username';

        $user = $account->get([$type => $identifier]);

        if (!$user) {
            CLI::error('User ' . $identifier . ' not found.');
            return;
        }

        if (!$authorization->addUserToGroup($user, $group)) {
            CLI::error($authorization->error());
            return;
        }

        CLI::write('User ' . $identifier . ' successfully added to ' . $group . ' group.', 'green');
    }
}
