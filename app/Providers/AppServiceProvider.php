<?php

namespace App\Providers;

use App\Support\TextLinkifier;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Usage in Blade: {!! Str::linkify($text) !!} works too, but this
        // directive is the shorthand: @linkify($text)
        Blade::directive('linkify', function ($expression) {
            return "<?php echo \App\Support\TextLinkifier::linkify($expression); ?>";
        });
    }
}
