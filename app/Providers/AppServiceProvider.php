<?php

namespace App\Providers;

use Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use App\Jobs\EnviarAlertaTarefaJob;
use App\Services\TarefasService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
         Gate::define('viewPulse', function ($user) {
            return in_array($user->email, [
                'daniel.dev@gmail.com',
            ]);
        });
    }
}
