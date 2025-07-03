<?php

namespace App\Services;

use App\Models\ListaTarefas;
use Auth;


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

            return $indexTarefas;

        } catch (Exception $e) {
            Log::error("Erro ao carregar as tarefas:{$e->getMessage()} | Linha: {$e->getLine()} | Trace: {$e->getTraceAsString()}");
            return view('errors.exception');
        }
    }

    public function criarTarefas($request)
    {
        $titulo = (string) $request->input('titulo');
        $descricao = (string) $request->input('descricao');
        $userId = (integer) Auth::id();

        $this->listaTarefas->create([
            'titulo' => $titulo,
            'descricao' => $descricao,
            'user_id' => $userId,
        ]);

    }

    public function buscarTarefa($tarefaId)
    {
        $tarefa = $this->listaTarefas->select('id', 'titulo', 'descricao', 'status')
             ->where('id',$tarefaId)
             ->first();
        
        return $tarefa;
    }

    public function atualizaTarefa($request,$tarefa)
    {
        $tarefaStatusUpdate = (string) $request->input('status');
        $titulo = (string) $request->input('titulo');
        $descricao = (string) $request->input('descricao');
        $userId = (integer) Auth::id();

        $tarefa->update([
                'titulo' => $titulo,
                'descricao' => $descricao,
                'status' => $tarefaStatusUpdate,
                'user_id' => $userId,
        ]);
    }

    public function buscaTarefaDeletada()
    {
        $indexTarefasDeleted = $this->listaTarefas
         ->where('user_id', Auth::id())
         ->whereNotNull('deleted_at')
         ->withTrashed()->get();
        
        return $indexTarefasDeleted;
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
}
