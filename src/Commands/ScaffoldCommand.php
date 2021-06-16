<?php

namespace Akizor\Scaffold\Commands;

use Illuminate\Config\Repository as Config;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Composer;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class ScaffoldCommand extends Command{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scaffold:general';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate all files and folders necesary for a basic LP or project structure';

    protected $files = null;

    protected $config;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $files, Composer $composer, Config $config)
    {
        parent::__construct();
        $this->files = $files;
        $this->config = $config;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->line('General structure scaffolding');
        $this->makeController();
        $this->makeBlades();
        $this->makeRoutes();
        $this->makeResources();
        $this->npmInstall();
        return 0;
    }

    public function makeController(){
        $stub = \str_replace(
            [], //array of identifiers
            [], //array of values
            $this->files->get(__DIR__ . '/stubs/general/controllers/home.stub')
        );
        $this->makeDir(app_path("Http/Controllers/Frontend/"));
        $this->files->put(app_path("Http/Controllers/Frontend/HomeController.php"), $stub);
    }

    public function makeBlades() {
        $dirs = [
            'site',
            'site/layouts',
            'site/layouts/partials',
            'site/pages'
        ];
        foreach($dirs as $dir) {
            $this->makeDir(base_path("resources/views/" . $dir));
        }

        $blades = $this->files->allFiles(__DIR__ . '/stubs/general/views');
        foreach($blades as $blade) {
            $stub = \str_replace(
                [], //array of identifiers
                [], //array of values
                $this->files->get($blade->getPathname())
            );
            $this->files->put(base_path("resources/views/site/" . $blade->getRelativePath() . "/" . $blade->getFilenameWithoutExtension() . ".blade.php"), $stub);
        }
    }

    public function makeRoutes() {
        $stub = \str_replace(
            [], //array of identifiers
            [], //array of values
            $this->files->get(__DIR__ . '/stubs/general/routes/frontend.stub')
        );
        $this->files->put(base_path("routes/frontend.php"), $stub);

        $stub = \str_replace(
            [], //array of identifiers
            [], //array of values
            $this->files->get(__DIR__ . '/stubs/general/provider/frontendserviceprovider.stub')
        );
        $this->files->put(app_path("Providers/FrontendServiceProvider.php"), $stub);

        $this->line("\nAdd the following provider to app\config.php");
        $this->info("App\Providers\FrontendServiceProvider::class \n");
    }

    public function makeResources(){
        $dirs = [
            'resources/scss',
            'resources/scss/tailwind',
            'resources/js',
            'resources/js/components',
        ];
        foreach($dirs as $dir) {
            $this->makeDir(base_path($dir));
        }

        $resources = $this->files->allFiles(__DIR__ . '/stubs/general/resources');
        foreach($resources as $resource) {
            $stub = \str_replace(
                [], //array of identifiers
                [], //array of values
                $this->files->get($resource->getPathname())
            );
            $extension = explode("/", $resource->getRelativePath()); //foldername is the file extension
            $this->files->put(base_path("resources/" . $resource->getRelativePath() . "/" . $resource->getFilenameWithoutExtension() . "." . $extension[0]), $stub);
        }

        $webpack = \str_replace(
            [], //array of identifiers
            [], //array of values
            $this->files->get(__DIR__ . '/stubs/general/webpack.stub')
        );
        $this->files->put(base_path("webpack.mix.js"), $webpack);

        $tailwind = \str_replace(
            [], //array of identifiers
            [], //array of values
            $this->files->get(__DIR__ . '/stubs/general/tailwind.stub')
        );
        $this->files->put(base_path("tailwind.config.js"), $tailwind);
    }

    public function makeDir($dir)
    {
        $info = pathinfo($dir);
        $dir = isset($info['extension']) ? $info['dirname'] : $dir;
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        if (!is_dir($dir)) {
            $this->error("It wasn't possible to create capsule directory {$dir}");
            die;
        }
    }

    public function npmInstall(){
        $this->line("Installing NPM Packages");

        $command = [
            "npm",
            "install",
            "-D"
        ];

        $this->line(implode(" ", \array_merge($command, $this->config->get('scaffold.npm_packages'))));
        $this->info("Sometimes, the install command doesn't update packages.json. Execute the above command yourself and should be fine.");
        
        $process = new Process($command, base_path());
        $process->setTty(Process::isTtySupported());
        $process->setTimeout(300);
        $process->run();
    }
}
