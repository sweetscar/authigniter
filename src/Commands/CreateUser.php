<?php

namespace SweetScar\AuthIgniter\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use SweetScar\AuthIgniter\Entities\User;

class CreateUser extends BaseCommand
{
    protected $group = 'AuthIgniter';
    protected $name = 'ai:user:create';
    protected $usage = 'ai:user:create';
    protected $description = 'Create new user.';

    public function run(array $params)
    {
        $account = service('account');
        $config = config('AuthIgniter');
        $authorization = service('authorization');
        $minPasswordLength = $config->minimumPasswordLength;
        $minPasswordLength = ($minPasswordLength < 6 || $minPasswordLength > 15) ? 6 : $minPasswordLength;
        $maxPasswordLength = $config->maximumPasswordLength;
        $maxPasswordLength = ($maxPasswordLength < 15 || $maxPasswordLength > 30) ? 30 : $maxPasswordLength;

        $minUsernameLength = $config->minimumUsernameLength;
        $minUsernameLength = ($minUsernameLength < 3 || $minUsernameLength > 6) ? 3 : $minUsernameLength;
        $maxUsernameLength = $config->maximumUsernameLength;
        $maxPasswordLength = ($maxUsernameLength < 6 || $maxUsernameLength > 30) ? 30 : $maxUsernameLength;

        $user = new User();

        $email = CLI::prompt('User email', null, 'required|valid_email|is_unique[users.email]|max_length[255]');
        $user->setEmail($email);

        if ($config->enableUsername) {
            $username = CLI::prompt('Username', null, "required|min_length[$minUsernameLength]|max_length[$maxUsernameLength]|is_unique[users.username]alpha_numeric");
            $user->setUsername($username);
        }

        $password = CLI::prompt('Password', null, "required|min_length[$minPasswordLength]|max_length[$maxPasswordLength]");
        $user->setPassword($password);

        $activate = CLI::prompt('Activate user', ['y', 'n'], 'required');
        if ($activate == 'y') {
            $user->activate();
        } elseif ($activate == 'n') {
            $user->deactivate();
        } else {
            $user->deactivate();
        }

        $verifyEmail = CLI::prompt('Verify email', ['y', 'n'], 'required');
        if ($verifyEmail == 'y') {
            $user->verifyEmail();
        } elseif ($verifyEmail == 'n') {
            $user->unverifyEmail();
        } else {
            $user->unverifyEmail();
        }

        $group = CLI::prompt('Add to group', null, 'alpha_dash');

        $userAccount = $account->create($user, true);

        if (!$userAccount) {
            CLI::error($account->error(), 'red');
            return;
        }
        if ($group) {
            $authorization->addUserToGroup($userAccount, $group);
        }
        CLI::write('Account created successfully.', 'green');
        return;
    }
}
