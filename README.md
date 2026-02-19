# User Activity Log Package for Laravel

**Version:** 1.0.0  
**Author:** Tarek  

---

## Description

This package automatically logs user activities in a Laravel application. It tracks login, logout, model creation, updates, deletions, and all requests. Guest users are also tracked. Old and new data, IP address, user agent, and session info are stored for detailed auditing.  

**Features:**
- Use the `LogActivity` trait in any model to track CRUD operations.  
- Middleware logs all requests automatically.  
- Tracks both authenticated and guest users.  
- Stores old and new data on updates/deletes.  
- Captures IP, browser info, session ID, and request method.  

---

## Requirements

- PHP >= 7.4  
- Laravel 7, 8, 9  
- Database: MySQL / PostgreSQL / SQLite  

---

## Installation & Setup

1. Install via Composer:

```bash
composer require tarek111/user-activity-log-pro


php artisan vendor:publish --provider="Tarek\UserActivityLog\UserActivityLogServiceProvider"
php artisan migrate

#Configuration
config/activitylog.php
return [
    'log_methods' => ['POST', 'PUT', 'PATCH', 'DELETE'], // Methods
    'log_guest_actions' => true, // guest actions log
];

#Usage
1. Middleware

// app/Http/Kernel.php
protected $middlewareGroups = [
    'web' => [
        \Tarek\UserActivityLog\Middleware\LogUserActivity::class,
    ],
];

2. Model Trait

use Tarek\UserActivityLog\Traits\LogActivity;

class Customer extends Model
{
    use LogActivity;
}

3. Accessing Logs

UserActivityLog
use Tarek\UserActivityLog\Models\UserActivityLog;

// latest 10 logs
$logs = UserActivityLog::latest()->take(10)->get();

4. Example Columns

| Column       | Description                                   |
| ------------ | --------------------------------------------- |
| id           | Log ID                                        |
| user_id      | User ID (Guest hole null)                     |
| action       | login, logout, create, update, delete, action |
| description  | Model or action description                   |
| model        | Model class name (if applicable)              |
| model_id     | Model ID (if applicable)                      |
| old_data     | Old data before update/delete                 |
| new_data     | New data after create/update                  |
| is_logged_in | User login status                             |
| ip_address   | User IP                                       |
| user_agent   | Browser info                                  |
| method       | HTTP method                                   |
| url          | Request URL                                   |
| session_id   | Session ID                                    |
| created_at   | Timestamp                                     |

5. Logging Custom Actions
use Tarek\UserActivityLog\Helpers\ActivityLogger;

ActivityLogger::log('action', 'Custom user action', [
    'model' => Customer::class,
    'model_id' => $customer->id,
    'old_data' => $customer->getOriginal(),
    'new_data' => $customer->toArray()
]);

6. Blade Example
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Log ID</th>
            <th>User</th>
            <th>Action</th>
            <th>Description</th>
            <th>Old Data</th>
            <th>New Data</th>
            <th>IP</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        @foreach($activity_logs as $log)
        <tr>
            <td>{{ $log->id }}</td>
            <td>{{ $log->user_id ?? 'Guest' }}</td>
            <td>{{ ucfirst($log->action) }}</td>
            <td>{{ $log->description }}</td>
            <td><pre>{{ json_encode($log->old_data, JSON_PRETTY_PRINT) }}</pre></td>
            <td><pre>{{ json_encode($log->new_data, JSON_PRETTY_PRINT) }}</pre></td>
            <td>{{ $log->ip_address }}</td>
            <td>{{ $log->created_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
