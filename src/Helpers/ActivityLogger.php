<?php

namespace Tarek\UserActivityLog\Helpers;

use Tarek\UserActivityLog\Models\UserActivityLog;

class ActivityLogger
{
    public static function log($action, $description, $extra = [])
    {
        UserActivityLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'description' => $description,
            'model' => $extra['model'] ?? null,
            'model_id' => $extra['model_id'] ?? null,
            'old_data' => $extra['old_data'] ?? null,
            'new_data' => $extra['new_data'] ?? null,
            'is_logged_in' => auth()->check(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'method' => request()->method(),
            'url' => request()->fullUrl(),
            'session_id' => session()->getId(),
        ]);
    }
}
