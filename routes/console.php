<?php

use Illuminate\Support\Facades\Schedule;

// Daily 00:05 — update days_overdue on pending/partial accounts receivable
Schedule::call(function () {
    \App\Models\AccountReceivable::whereIn('status', ['pending', 'partial'])
        ->where('due_date', '<', now())
        ->each(fn($ar) => $ar->updateDaysOverdue());
})->dailyAt('00:05');

// 1st of each month 06:00 — log monthly billing cycle start
Schedule::call(function () {
    \Illuminate\Support\Facades\Log::info('Monthly billing cycle started: ' . now()->format('Y-m'));
})->monthlyOn(1, '06:00');
