<?php
namespace App\Jobs;

use App\Events\TestePusherEvent;
use App\Models\ListaTarefas;
use App\Services\TarefasService;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EnviarAlertaTarefaJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    protected $tarefaId;
    public $tries = 3;
    public $timeout = 200;

    public function __construct($tarefaId)
    {
        $this->tarefaId = $tarefaId;
    }


    public function handle(TarefasService $tarefasService)
    {
        $tarefa = ListaTarefas::find($this->tarefaId);
        if (!$tarefa) {
            \Log::warning("Tarefa {$this->tarefaId} não encontrada.");
            return;
        }


        event(new TestePusherEvent($tarefa));


        // Mail::to($tarefa->user->email)->send(new AlertaTarefaMail($tarefa));


        $tarefa->alerta_enviado = true;
        $tarefa->update(['alerta_enviado' => true]);


        \Log::info("Alerta enviado para tarefa {$this->tarefaId}.");

    }

    public function failed(Exception $exception)
    {
        \Log::error("Job falhou: " . $exception->getMessage());
    }
}

