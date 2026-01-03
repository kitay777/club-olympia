<?php

namespace App\Listeners;

// app/Listeners/LogLoginHistory.php
use Illuminate\Auth\Events\Login;
use App\Models\LoginHistory;

class LogLoginHistory
{
    public function handle(Login $event): void
    {
        LoginHistory::create([
            'user_id'      => $event->user->id,
            'ip_address'   => request()->ip(),
            'user_agent'   => request()->userAgent(),
            'logged_in_at' => now(),
        ]);
    }
}

