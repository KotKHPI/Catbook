<?php

namespace App\Providers;

use App\Http\ViewComposers\ActivityComposer;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::aliasComponent('components.badge', 'badge');
        Blade::aliasComponent('components.update', 'update');
        Blade::aliasComponent('components.card', 'card');
        Blade::aliasComponent('components.tags', 'tags');

        view()->composer('home.cat', ActivityComposer::class);
    }
}
