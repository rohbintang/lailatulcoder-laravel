<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Pest\Matchers\Any;

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
        $this->registerBladeDirectives();
        $this->registerBladeConditionals();
    }

    private function registerBladeDirectives(): void 
    {
        Carbon::setLocale('id');

        Blade::directive('rupiah', function (string $expression) {
            return "<?php echo 'Rp ' . number_format($expression, 0, ',', '.'); ?>";
        });

        Blade::directive('tanggal', function (string $expression) {
            return "<?php echo Carbon::parse($expression)->locale('id')->translatedFormat('d F Y'); ?>";
        });

        Blade::directive('tanggalwaktu', function (string $expression) {
            return "<?php echo Carbon::parse($expression)->locale('id')->translatedFormat('d F Y H:i'); ?>";
        });
    }

    private function registerBladeConditionals(): void 
    {
        Blade::if('admin', function() {
             Auth::check() && auth::user()->role('admin');
        });
        Blade::if('seller', function() { 
            Auth::check() && auth::user()->role('seller');
        });
        Blade::if('subscribed', function(string $plan= 'Any') 
        {
            if (! auth::check()) return false;
            return $plan === 'any'
            ? auth::user()->subscribed()
            : auth::user()->subscribedToPrice($plan);
        });
    }
}