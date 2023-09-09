<?php

namespace Shakilnadim\LaravelCrud\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use RuntimeException;
use Symfony\Component\Process\Process;
use function Laravel\Prompts\intro;
use function Laravel\Prompts\outro;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravel-crud:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install laravel crud package';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        intro('Laravel Crud');

        $this->updateNodePackages(fn ($packages) => [
            '@tailwindcss/forms' => '^0.5.2',
            'autoprefixer' => '^10.4.2',
            'postcss' => '^8.4.6',
            'tailwindcss' => '^3.1.0',
        ] + $packages);

        // Controllers...
        (new Filesystem)->ensureDirectoryExists(app_path('Http/Controllers'));
        copy(__DIR__.'/../../stubs/app/Http/Controllers/TestController.php', app_path('Http/Controllers/TestController.php'));

        // Requests...
        (new Filesystem)->ensureDirectoryExists(app_path('Http/Requests'));
        copy(__DIR__.'/../../stubs/app/Http/Requests/TestRequest.php', app_path('Http/Requests/TestRequest.php'));

        // Views...
        (new Filesystem)->ensureDirectoryExists(resource_path('views/test'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/resources/views/test', resource_path('views/test'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/resources/views/components', resource_path('views/components'));


        // Routes...
        copy(__DIR__.'/../../stubs/routes/web.php', base_path('routes/web.php'));

        // Tailwind / Vite...
        copy(__DIR__.'/../../stubs/tailwind.config.js', base_path('tailwind.config.js'));
        copy(__DIR__.'/../../stubs/postcss.config.js', base_path('postcss.config.js'));
        copy(__DIR__.'/../../stubs/vite.config.js', base_path('vite.config.js'));
        copy(__DIR__.'/../../stubs/resources/css/app.css', resource_path('css/app.css'));
        copy(__DIR__.'/../../stubs/resources/js/app.js', resource_path('js/app.js'));

        // Migrations...
        copy(__DIR__.'/../../stubs/database/2023_09_09_061722_create_tests_table.php', base_path('database/migrations/2023_09_09_061722_create_tests_table.php'));

        // Models
        copy(__DIR__.'/../../stubs/app/Models/Test.php', app_path('Models/Test.php'));

        $this->components->info('Installing and building Node dependencies.');
        $this->runCommands(['npm install', 'npm run build']);

        $this->components->info('Running migrations');
        $this->runCommands(['php artisan migrate']);

        $this->line('');
        outro("Laravel Crud Installed Successfully");
    }

    private function updateNodePackages(callable $callback, $dev = true): void
    {
        if (! file_exists(base_path('package.json'))) {
            return;
        }

        $configurationKey = $dev ? 'devDependencies' : 'dependencies';

        $packages = json_decode(file_get_contents(base_path('package.json')), true);

        $packages[$configurationKey] = $callback(
            array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : [],
            $configurationKey
        );

        ksort($packages[$configurationKey]);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
    }

    private function runCommands($commands)
    {
        $process = Process::fromShellCommandline(implode(' && ', $commands), null, null, null, null);

        if ('\\' !== DIRECTORY_SEPARATOR && file_exists('/dev/tty') && is_readable('/dev/tty')) {
            try {
                $process->setTty(true);
            } catch (RuntimeException $e) {
                $this->output->writeln('  <bg=yellow;fg=black> WARN </> '.$e->getMessage().PHP_EOL);
            }
        }

        $process->run(function ($type, $line) {
            $this->output->write('    '.$line);
        });
    }
}
