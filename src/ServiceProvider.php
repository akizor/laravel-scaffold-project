<?php

namespace Akizor\Scaffold;

use Akizor\Scaffold\Commands\ScaffoldCommand;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    const CONFIG_PATH = __DIR__ . '/../config/scaffold.php';

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ScaffoldCommand::class,
            ]);
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(
            self::CONFIG_PATH,
            'scaffold'
        );

        $this->app->bind('scaffold', function () {
            return new Scaffold();
        });
    }
}
