<?php

namespace App\Console\Commands;

use App\Jobs\EnviarAlertaTarefaJob;
use App\Models\ListaTarefas;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Str;

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
    protected $description = 'Verifica tarefas com vencimento nos próximos 30 minutos e dispara alertas';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $agora = Carbon::now()->startOfMinute();

            $limite = $agora->copy()->addMinutes(30);


            $tarefas = ListaTarefas::where('alerta_enviado', 0) 
                ->whereBetween('data_de_vencimento', [$agora, $limite])
                ->get();

            // Log::info(" Verificando tarefas entre {$agora} e {$limite}. Encontradas: " . $tarefas->count());

            foreach ($tarefas as $tarefa) {
                // Log::info("Enfileirando job para tarefa ID {$tarefa->id}");
                EnviarAlertaTarefaJob::dispatch($tarefa->id);
            }

            $this->info(count($tarefas) . ' ' . Str::plural('tarefa', count($tarefas)) . ' encontrada(s) e alertas disparados.');

        } catch (Exception $e) {
            Log::error("Erro ao verificar tarefas próximas do vencimento {$e->getMessage()}");
            $this->error("Erro ao executar comando. Consulte os logs.");
        }
    }
}
