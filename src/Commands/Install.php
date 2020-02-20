<?php

namespace Code4Romania\Cms\Commands;

use Code4Romania\Cms\CmsServiceProvider;
use Illuminate\Console\Command;
use Illuminate\Database\DatabaseManager;
use Illuminate\Filesystem\Filesystem;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:install {--y|yes : Automatic yes to initial prompt}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install CMS features';

    /** @var Filesystem */
    protected $files;

    /** @var DatabaseManager */
    protected $db;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $files, DatabaseManager $db)
    {
        parent::__construct();

        $this->files = $files;
        $this->db = $db;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->warn('This is a potentially destructive action!');
        $this->warn('It will (re)publish and overwrite all the files provided by this package.');

        if (!$this->option('yes') && !$this->confirm('Are you sure you want to continue?')) {
            return;
        }

        $this->warn('You have been warned.');

        $this->removeFiles();
        $this->publish();
        $this->installTwill();
    }

    public function checkDatabaseConnection(): bool
    {
        try {
            $this->db->connection()->getPdo();
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    private function removeFiles(): void
    {
        $this->line('');

        $this->info('Emptying the resources directory.');
        $this->files->cleanDirectory(resource_path());

        $this->info('Blanking the default route files.');
        collect($this->files->files(app()->basePath('routes')))
            ->each(function ($file) {
                $this->files->replace(
                    $file->getPathname(),
                    "<?php // this file is intentionally left blank"
                );
            });

        $this->info('Deleting previously copied files.');

        $filesToDelete = [
            app()->basePath('.gitignore'),
            app()->basePath('.env.example'),
        ];

        $assetFiles = collect(CmsServiceProvider::$assetFiles)
            ->map(fn ($fileName) => app()->basePath($fileName));

        $configFiles = collect(CmsServiceProvider::$configFiles)
            ->map(fn ($fileName) => config_path($fileName));

        collect($filesToDelete)
            ->merge($configFiles)
            ->merge($assetFiles)
            ->each(function ($filePath) {
                $this->info(
                    "Removed File <warning>[{$filePath}]</warning>"
                );
                $this->files->delete($filePath);
            });

        $this->info('Deleting complete.');
        $this->line('');
    }

    private function installTwill(): void
    {
        $this->call('twill:blocks');

        if ($this->confirm('Do you also want to run the Twill install process?')) {
            if ($this->checkDatabaseConnection()) {
                $this->call('twill:install');
            } else {
                $this->line('');
                $this->warn('After configuring the database access, you still need to run `php artisan twill:install`');
            }
        }
    }

    /**
     * Publishes a specific tag
     *
     * @param null|string $tag
     * @return void
     */
    private function publish(?string $tag = null): void
    {
        $arguments = [
            '--provider' => CmsServiceProvider::class,
        ];

        if (!is_null($tag)) {
            $arguments['--tag'] = $tag;
        }

        $this->info('Publishing vendor files.');
        $this->call('vendor:publish', $arguments);
        $this->line('');
    }
}
