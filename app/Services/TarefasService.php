<?php

namespace App\Services;

use App\Models\ListaTarefas;
use App\Events\TestePusherEvent;
use Auth;
use Date;
use DateTime;
use Illuminate\Support\Carbon;


class TarefasService
{
    private ListaTarefas $listaTarefas;


    /**
     * Create a new class instance.
     */
    public function __construct(ListaTarefas $listaTarefas)
    {
        $this->listaTarefas = $listaTarefas;
    }

    /**
     * Método Index
     * @return View
     * @author dwictor0
     */
    public function indexTarefas()
    {
        try {
            $userId = (integer) Auth::id();
            $indexTarefas = $this->listaTarefas->where('user_id', $userId)->get();

            return $this->listaTarefas->where('user_id', $userId)->get();
        } catch (Exception $e) {
            Log::error("Erro ao carregar as tarefas:{$e->getMessage()} | Linha: {$e->getLine()} | Trace: {$e->getTraceAsString()}");
            return view('errors.exception');
        }
    }

    public function criarTarefas($request)
    {
        $titulo = (string) $request->input('titulo');
        $descricao = (string) $request->input('descricao');
        $status = $request->input('status');
        $prioridadeTarefa = $request->input('prioridade');
        $userId = (integer) Auth::id();
        $data = Carbon::parse($request->input('data_vencimento'));

        $this->listaTarefas->create([
            'titulo' => $titulo,
            'descricao' => $descricao,
            'data_de_vencimento' => $data,
            'prioridade' => $prioridadeTarefa,
            'status' => $status,
            'user_id' => $userId,
        ]);
    }

    public function buscarTarefa($tarefaId)
    {
        return $this->listaTarefas->select('id', 'titulo', 'descricao', 'status', 'data_de_vencimento')
            ->where('id', $tarefaId)
            ->first();

    }

    public function atualizaTarefa($request, $tarefa)
    {

        $tarefaStatusUpdate = (string) $request->input('status');
        $titulo = (string) $request->input('titulo');
        $descricao = (string) $request->input('descricao');
        $dataValidade = $request->input('data_vencimento');
        $userId = (integer) Auth::id();

        $tarefa->update([
            'titulo' => $titulo,
            'descricao' => $descricao,
            'status' => $tarefaStatusUpdate,
            'data_de_vencimento' => $dataValidade,
            'user_id' => $userId,
        ]);
    }

    public function buscaTarefaDeletada()
    {
        return $this->listaTarefas
            ->where('user_id', Auth::id())
            ->whereNotNull('deleted_at')
            ->withTrashed()->get();


    }

    public function deletarTarefa($id)
    {
        $tarefa = $this->listaTarefas->withTrashed()->findOrFail($id);

        if ($tarefa->trashed()) {
            $tarefa->forceDelete();
        } else {
            $tarefa->delete();
        }
    }

    public function restaurarTarefa($id)
    {
        $tarefa = $this->listaTarefas->withTrashed()->findOrFail($id);

        $tarefa->restore();
    }
    public function buscarTarefasProximas(int $minutosAntes = 30)
    {
        $agora = now();
        $limite = $agora->copy()->addMinutes($minutosAntes);

        return $this->listaTarefas
            ->where('alerta_enviado', false) // ou outra coluna que marque se já enviou alerta
            ->whereBetween('data_de_vencimento', [$agora, $limite])
            ->get();
    }

}
