<?php

namespace LaravelIcons\Commands;

use Illuminate\Console\Command;

class GenerateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'icons:generate {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate icons';

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
        if (!file_exists(config('laravel-icons.source_path'))) {
            $this->error('Source path not found');
            exit;
        }

        if (!file_exists(resource_path('views/components/icons'))) {
            mkdir(resource_path('views/components/icons'), 0755, true);
        }

        foreach (glob(config('laravel-icons.source_path') . '/{,*/,*/*/,*/*/*/}*.svg', GLOB_BRACE) as $icon) {
            $icon_name = explode('/', $icon);
            $icon_name = str_replace('.svg', '', array_pop($icon_name));
            $view_file = resource_path('views/components/icons/' . $icon_name . '.blade.php');

            if (!file_exists($view_file) && !$this->option('force')) {
                continue;
            }

            $svg = file_get_contents($icon);
            $svg = preg_replace('/((<\?xml(.*)\?>)|(<!--(.*)-->)|(\s|\t|\n)(version|id|enable-background|width|height|xmlns:?\w+?|\sx|\sy|style|xml:?\w+?)=["\']?((?:.(?!["\']?\s+(?:\S+)=|[>"\']))+.)["\']?|\n|\t|(<g>\n<\/g>)|(<(title|desc)>(.+?)<\/(title|desc)>)|(\s{2,}))/m', '', $svg);
            $svg = str_replace('<svg ', '<svg {!! $attributes !!} ', $svg);

            file_put_contents($view_file, $svg);

            $this->line($icon_name . ' created');
        }

        $this->callSilent('view:clear');

        $this->info('Done!');
    }
}
