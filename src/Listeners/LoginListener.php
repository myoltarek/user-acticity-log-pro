<?php

namespace Tarek\UserActivityLog\Listeners;

use Illuminate\Auth\Events\Login;
use Tarek\UserActivityLog\Helpers\ActivityLogger;

class LoginListener
{
    public function handle(Login $event)
    {
        ActivityLogger::log('login', 'User logged in');
    }
}
