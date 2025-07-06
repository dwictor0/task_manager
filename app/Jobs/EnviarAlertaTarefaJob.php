<?php
namespace App\Jobs;

use App\Events\PusherEvent;
use App\Models\ListaTarefas;
use App\Services\TarefasService;
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
        $tarefa = ListaTarefas::find($this->tarefaId);
        if (!$tarefa) {
            Log::warning("Tarefa {$this->tarefaId} não encontrada.");
            return;
        }


        event(new PusherEvent($tarefa));


        // Mail::to($tarefa->user->email)->send(new AlertaTarefaMail($tarefa));


        $tarefa->update([
         'alerta_enviado' => true,
         'alerta_enviado_at' => now(), 
        ]);



        Log::info("Alerta enviado para tarefa {$this->tarefaId}.");

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

