<?php

namespace App\Providers;

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
        $this->app->booted(function () {
            app(Schedule::class)->everyMinute()->call(function () {

                $tarefasProximas = app(TarefasService::class)->buscarTarefasProximas();

                foreach ($tarefasProximas as $tarefa) {
                    dispatch(new EnviarAlertaTarefaJob($tarefa->id));
                }
            });
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
