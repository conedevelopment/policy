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
            __DIR__ . '/../resources/js' => resource_path(
                version_compare($this->app->version(), '5.7.0', '<')
                ? 'assets/js/policies' : 'js/policies'
            ),
        ]);

        // Register the commands
        if ($this->app->runningInConsole()) {
            $this->commands([JsPolicyMakeCommand::class]);
        }

        // Register the @currentUser blade directive
        Blade::directive('currentUser', function ($key) {
            return sprintf(
                '<script>window[%s] = <?php echo json_encode(Auth::user()); ?>;</script>',
                $key ?: "'user'"
            );
        });
    }
}
