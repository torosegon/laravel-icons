<?php

namespace LaravelIcons\Providers;

use LaravelIcons\Commands\GenerateCommand;
use LaravelIcons\Commands\ListCommand;
use LaravelIcons\Compilers\IconTagCompiler;
use Illuminate\Support\ServiceProvider;

class LaravelIconsServiceProvider extends ServiceProvider
{
    /**
     * ServiceProvider register
     */
    public function register(): void
    {
        $this->registerCommands();
        $this->registerConfig();
        $this->registerTagCompiler();
        $this->registerRoutes();
    }

    /**
     * Registering compiler
     */
    protected function registerTagCompiler(): void
    {
        if (method_exists($this->app['blade.compiler'], 'precompiler')) {
            $this->app['blade.compiler']->precompiler(function ($string) {
                return (new IconTagCompiler())->compile($string);
            });
        }
    }

    /**
     * Registering icon route
     */
    private function registerRoutes(): void
    {
        $this->app['router']
            ->get(config('icons.url_prefix') . '/{icon}.svg', function(string $icon) {
                return view()->exists('components/icons/' . $icon)
                    ? view('components/icons/' . $icon, ['attributes' => ''])
                    : abort(404);
            })
            ->where(['icon' => '(.*)'])
            ->name('icon');
    }

    /**
     * Merging and publishing config file
     */
    private function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/laravel-icons.php', 'icons');

        $this->publishes([
            __DIR__ . '/../../config/laravel-icons.php' => config_path('laravel-icons.php')
        ], ['icons', 'icons:config']);
    }

    /**
     * Registering package commands
     */
    private function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                GenerateCommand::class,
                ListCommand::class,
            ]);
        }
    }
}
