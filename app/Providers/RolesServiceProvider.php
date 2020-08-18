<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class RolesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // dd('here');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        Blade::directive('directive_name', function () {
            return 'My First Blade Directive';
        });
        Blade::directive('role', function ($roles) {
            dd($roles);
            return "<?php if(auth()->check() && auth()->user()->hasRole($roles)) : ?>"; //return this if statement inside php tag
        });

        Blade::directive('endrole', function ($roles) {
            return "<?php endif; ?>"; //return this endif statement inside php tag
        });
    }
}
