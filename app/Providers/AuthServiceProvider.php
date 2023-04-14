<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('q', function($user) {
            return $user->admin == '0';  // pelamar
        });
        Gate::define('w', function($user) {
            return $user->admin == '1';  // dev
        });
        Gate::define('e', function($user) {
            return $user->admin == '2';  // superadmin
        });
        Gate::define('r', function($user) {
            return $user->admin == '3';  // hr staff
        });
        Gate::define('t', function($user) {
            return $user->admin == '4';  // head of dept
        });
        Gate::define('y', function($user) {
            return $user->admin == '5';  // admin of dept
        });
        Gate::define('u', function($user) {
            return $user->admin == '6';   // interviewer
        });
    }
}
