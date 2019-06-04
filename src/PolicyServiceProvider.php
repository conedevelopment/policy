<?php

namespace Pine\Policy;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Pine\Policy\Console\Commands\JsPolicyMakeCommand;

class PolicyServiceProvider extends ServiceProvider
{
    /**
     * Boot any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish the assets
        $this->publishes([
            __DIR__ . '/../resources/js' => resource_path('js/policies'),
        ]);

        // Register the commands
        if ($this->app->runningInConsole()) {
            $this->commands([JsPolicyMakeCommand::class]);
        }

        // Register the @currentUser blade directive
        Blade::directive('currentUser', function ($key) {
            return sprintf(
                '<script>window.%s = <?php echo json_encode(Auth::user()); ?>;</script>',
                str_replace(['"', "'"], '', $key ?: 'user')
            );
        });
    }
}
