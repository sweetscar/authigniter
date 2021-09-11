<?php

namespace SweetScar\AuthIgniter\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class DeleteUser extends BaseCommand
{
    protected $group = 'AuthIgniter';
    protected $name = 'ai:delete_user';
    protected $usage = 'ai:delete_user [identifier] [permanent]';
    protected $arguments = [
        'identifier' => "Email or username of user account.",
        'permanent' => '[y/n] Delete user permanently or not'
    ];
    protected $description = 'Deleting an user account.';

    public function run(array $params)
    {
        $account = service('account');

        $identifier = array_shift($params);
        if (empty($identifier)) {
            $identifier = CLI::prompt('Identifier (email or username)', null, 'required');
        }

        $permanent = array_shift($params);
        if (empty($permanent)) {
            $permanent = CLI::prompt('Delete permanently', ['y', 'n'], 'required');
        }

        $type = (filter_var($identifier, FILTER_VALIDATE_EMAIL)) ? 'email' : 'username';

        $user = $account->get([$type => $identifier]);

        if (!$user) {
            CLI::error('User ' . $identifier . ' not found.');
            return;
        }

        if ($permanent == 'y') {
            $permanent = true;
        } else {
            $permanent = false;
        }

        if (!$account->delete($user, $permanent)) {
            CLI::error($account->error());
            return;
        }

        CLI::write('User ' . $identifier . ' successfully deleted.', 'green');
    }
}
