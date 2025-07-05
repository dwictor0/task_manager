<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\VerificarTarefasVencimento;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('app:verificar-tarefas-vencimento', function () {
    $this->call(VerificarTarefasVencimento::class);
})->describe('Verifica tarefas próximas do vencimento e dispara alertas');