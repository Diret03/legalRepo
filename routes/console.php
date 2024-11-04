<?php

use Carbon\Carbon;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;
use App\Notifications\AccountDeactivatedTime;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('users:deactivate-inactive', function () {

    $users = User::where('status', true)
        ->where(function ($query) {
            $query->where('last_login_at', '<', Carbon::now()->subDays(60))
                ->orWhereNull('last_login_at');
        })
        ->get();

//    $this->info("Deactivated {$deactivatedUsers} inactive users.");

    if ($users->isEmpty()) {
        $this->info("No se han encontrado usuarios inactivos para desactivar.");
        return;
    }

    $this->info("Usuarios desactivados (".Carbon::now()->format("d-m-Y H:i:s")."):");
    foreach ($users as $user) {
        $user->status = false;
        $user->save();

        $user->notify(new AccountDeactivatedTime());

        $this->info($user->email);
    }

})->purpose('Deactivate users who haven\'t logged in for 60 days')
    ->daily()
    ->appendOutputTo(storage_path('logs/scheduler.log'));
