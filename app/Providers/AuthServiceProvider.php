<?php

declare(strict_types=1);

namespace App\Providers;

use App\Auth\AppUserProvider;
use App\Eloquents\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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

        Auth::provider('app', function (Application $app, array $config) {
            return new AppUserProvider($app['hash'], $config['model']);
        });

        // メール認証が完了している場合のみ使える機能
        Gate::define('use-all-features', function (User $user) {
            return $user->areBothEmailsVerified();
        });
    }
}
