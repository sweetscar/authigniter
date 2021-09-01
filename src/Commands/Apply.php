<?php

namespace SweetScar\AuthIgniter\Commands;

use CodeIgniter\CLI\CLI;
use CodeIgniter\CLI\BaseCommand;
use Config\Autoload;

class Apply extends BaseCommand
{
    /**
     * The group the command is lumped under
     * when listing commands.
     *
     * @var string
     */
    protected $group = 'Authigniter';

    /**
     * The Command's name
     *
     * @var string
     */
    protected $name = 'authigniter:apply';

    /**
     * the Command's usage description
     *
     * @var string
     */
    protected $usage = 'authigniter:apply';

    /**
     * the Command's short description
     *
     * @var string
     */
    protected $description = 'Apply authigniter functionality into the current application.';

    /** 
     * Source path
     * 
     * @var string 
     */
    protected $sourcePath;

    /**
     * {@inheritdoc}
     */

    public function run(array $params)
    {
        // $this->setSourcePath();

        // $map = directory_map($this->sourcePath . '/Database/Migrations');

        // foreach ($map as $file) {
        //     $content = file_get_contents("{$this->sourcePath}/Database/Migrations/{$file}");
        //     $content = $this->replaceNamespace($content, 'Sweetscar\Authigniter\Database\Migrations', 'Database\Migrations');

        //     $this->writeFile("Database/Migrations/{$file}", $content);
        // }

        CLI::write('Remember to run `php spark migrate` to migrate the database.', 'yellow');
    }

    /**
     * Set the current source path from which all other files are located.
     *
     * @return mixed
     */
    protected function setSourcePath()
    {
        $this->sourcePath = realpath(__DIR__ . '/../');

        if ($this->sourcePath === '/' || empty($this->sourcePath)) {
            CLI::error('Unable to determine the correct source directory. Bailing.');
            exit();
        }
    }

    protected function replaceNamespace(string $contents, string $originalNamespace, string $newNamespace): string
    {
        $appNamespace      = APP_NAMESPACE;
        $originalNamespace = "namespace {$originalNamespace}";
        $newNamespace      = "namespace {$appNamespace}\\{$newNamespace}";

        return str_replace($originalNamespace, $newNamespace, $contents);
    }

    protected function writeFile(string $path, string $content)
    {
        $config  = new Autoload();
        $appPath = $config->psr4[APP_NAMESPACE];

        $filename  = $appPath . $path;
        $directory = dirname($filename);

        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        if (file_exists($filename)) {
            $overwrite = (bool) CLI::getOption('f');

            if (!$overwrite && CLI::prompt("File '{$path}' already exists in destination. Overwrite?", ['n', 'y']) === 'n') {
                CLI::error("Skipped {$path}. If you wish to overwrite, please use the '-f' option or reply 'y' to the prompt.");
                return;
            }
        }

        if (write_file($filename, $content)) {
            CLI::write(CLI::color('Created: ', 'green') . $path);
        } else {
            CLI::error("Error creating {$path}.");
        }
    }
}
