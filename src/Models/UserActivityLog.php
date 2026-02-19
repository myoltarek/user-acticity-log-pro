<?php

namespace Tarek\UserActivityLog\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class UserActivityLog extends Model
{
    protected $guarded = [];

    protected $casts = [
        'old_data' => 'array',
        'new_data' => 'array',
        'is_logged_in' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
