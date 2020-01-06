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
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('isAdministrator', function ($user) {return $user->hasRole('Administrator'); });
        Gate::define('isPersoneelsdienst', function ($user) {return $user->hasRole('Personeelsdienst'); });
        Gate::define('isDiensthoofd', function ($user) {return $user->hasRole('Diensthoofd'); });
        Gate::define('isToepassingsverantwoordelijke', function ($user) {return $user->hasRole('Toepassingsverantwoordelijke'); });

    }
}
