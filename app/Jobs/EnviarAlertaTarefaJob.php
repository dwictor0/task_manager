<?php
namespace App\Jobs;

use App\Events\PusherEvent;
use App\Models\ListaTarefas;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Exception;

class EnviarAlertaTarefaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $tarefaId;
    public $tries = 3;
    public $timeout = 200;

    public function __construct(int $tarefaId)
    {
        $this->tarefaId = $tarefaId;
    }

    /**
     * Summary of handle
     * @return void
     */
    public function handle()
    {
        try {
        $tarefa = ListaTarefas::find($this->tarefaId);

        event(new PusherEvent($tarefa));

            $tarefa->update([
                'alerta_enviado' => true,
                'alerta_enviado_at' => now(),
                'deleted_at' => now(),
            ]);

            // Log::info("Atualização feita com sucesso");
        } catch (Exception $e) {
            Log::error("Erro ao atualizar tarefa: " . $e->getMessage());
        }
        // Log::info("Alerta enviado para tarefa {$this->tarefaId}.");
    }

    /**
     * Summary of failed
     * @param Exception $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        Log::error("Job falhou: " . $exception->getMessage());
    }
}

