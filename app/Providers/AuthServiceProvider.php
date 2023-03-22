<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
         'App\Models\Model' => 'App\Policies\ModelPolicy',
        'App\Models\CatName' => 'App\Policies\CatNamePolicy'
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('home.secret', function ($user) {
            return $user->is_admin;
        });

//        Gate::define('update-cat', function($user, $cat) {
//            return $user->id == $cat->user_id;
//        });
//
//        Gate::define('delete-cat', function($user, $cat) {
//            return $user->id == $cat->user_id;
//        });
//
        Gate::before(function ($user, $ability) {
            if($user->is_admin && in_array($ability, ['update'])) {
                return true;
            }
        });

//        Gate::define('cats.update', 'App\Policies\CatNamePolicy@update');
//        Gate::define('cats.delete', 'App\Policies\CatNamePolicy@delete');

//        Gate::resource('cats', 'App\Policies\CatNamePolicy');
    }
}
