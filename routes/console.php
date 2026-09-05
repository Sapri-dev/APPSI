<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
|--------------------------------------------------------------------------
| Scheduled Tasks
|--------------------------------------------------------------------------
| instagram:refresh — Perbarui cache postingan Instagram APPSI setiap 6 jam
| Pastikan cron job sudah diaktifkan di server:
|   * * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1
*/
Schedule::command('instagram:refresh')->everySixHours()->withoutOverlapping();
