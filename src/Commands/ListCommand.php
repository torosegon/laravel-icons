<?php

namespace LaravelIcons\Commands;

use Illuminate\Console\Command;

class ListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'icons:list {--name=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all generated icons';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(): void
    {
        $name = $this->option('name');

        $icons = array_filter(glob(resource_path('views/components/icons') . '/*.blade.php'), function($icon) use ($name) {
            return $name ? (strpos(pathinfo($icon, PATHINFO_FILENAME), $name) !== false) : true;
        });

        $this->line(implode(PHP_EOL, array_map(function($icon) {
            return str_replace('.blade', '', pathinfo($icon, PATHINFO_FILENAME));
        }, $icons)));
    }
}
