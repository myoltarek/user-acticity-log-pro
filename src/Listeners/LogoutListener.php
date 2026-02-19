<?php

namespace Tarek\UserActivityLog\Listeners;

use Illuminate\Auth\Events\Logout;
use Tarek\UserActivityLog\Helpers\ActivityLogger;

class LogoutListener
{
    public function handle(Logout $event)
    {
        ActivityLogger::log('logout', 'User logged out');
    }
}
