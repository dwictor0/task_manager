<?php

namespace App\Console\Commands;

use App\Jobs\EnviarAlertaTarefaJob;
use App\Models\ListaTarefas;
use Carbon\Carbon;
use Illuminate\Console\Command;

class VerificarTarefasVencimento extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:verificar-tarefas-vencimento';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
    \Log::info('Comando VerificarTarefasVencimento executado.');
    $agora = Carbon::now();

    $tarefas = ListaTarefas::where('alerta_enviado', false)
        ->where('data_de_vencimento', '<=', $agora)
        ->pluck('id'); // só pega os IDs

    foreach ($tarefas as $tarefaId) {
        EnviarAlertaTarefaJob::dispatch($tarefaId);
    }

    $this->info(count($tarefas) . " tarefa(s) vencidas encontradas e alertas disparados.");
    }
}
