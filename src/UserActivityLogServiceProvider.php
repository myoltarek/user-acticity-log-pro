<?php

namespace Tarek\UserActivityLog;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Tarek\UserActivityLog\Listeners\LoginListener;
use Tarek\UserActivityLog\Listeners\LogoutListener;

class UserActivityLogServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->publishes([
            __DIR__.'/../config/activitylog.php' => config_path('activitylog.php'),
        ], 'activitylog-config');

        Event::listen(Login::class, LoginListener::class);
        Event::listen(Logout::class, LogoutListener::class);
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/activitylog.php', 'activitylog'
        );
    }
}
