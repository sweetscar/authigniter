<?php

namespace SweetScar\AuthIgniter\Commands;

use CodeIgniter\CLI\CLI;
use CodeIgniter\CLI\BaseCommand;

class AuthIgniter extends BaseCommand
{
    protected $group = 'Authigniter';
    protected $name = 'authigniter';
    protected $usage = 'authigniter';
    protected $description = 'Show AuthIgniter library information.';

    public function run(array $params)
    {
        CLI::write('What is AuthIgniter?', 'green');
        CLI::write('AuthIgniter is a simple and fast authentication and authorization library for CodeIgniter 4.');
        CLI::write('');
        CLI::write('Web page', 'green');
        CLI::write('https://sweetscar.github.io/authigniter/');
    }
}
