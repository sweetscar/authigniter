<?php

namespace SweetScar\AuthIgniter\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class DeactivateUser extends BaseCommand
{
    protected $group = 'AuthIgniter';
    protected $name = 'ai:deactivate_user';
    protected $usage = 'ai:deactivate_user [identifier]';
    protected $arguments = [
        'identifier' => "Email or username of user account.",
    ];
    protected $description = 'Deactivating an user account.';

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

        if (!$account->deactivate($user)) {
            CLI::error($account->error());
            return;
        }

        CLI::write('User ' . $identifier . ' successfully deactivated.', 'green');
    }
}
