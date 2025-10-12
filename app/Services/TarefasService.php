<?php

namespace App\Services;

use App\Jobs\EnviarEmail;
use App\Models\User;
use App\Models\ListaTarefas;
use App\Events\PusherEvent;
use Auth;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class TarefasService
{
    private ListaTarefas $listaTarefas;
    private User $usuarioTarefa;



    /**
     * Create a new class instance.
     */
    public function __construct(ListaTarefas $listaTarefas, User $usuarioTarefa)
    {
        $this->listaTarefas = $listaTarefas;
        $this->usuarioTarefa = $usuarioTarefa;
    }

    /**
     * Summary of indexTarefas
     * @return \Illuminate\Contracts\View\View|\Illuminate\Database\Eloquent\Collection<int, ListaTarefas>
     */
    public function indexTarefas()
    {
        try {
            $userId =  Auth::user();
            
            return $this->listaTarefas
            ->where('user_id', $userId->id)
            ->when($userId->tipo_usuario == 'administrador', function ($query) {
                return $query->orWhere('user_id','>=',1);
            })->get();
        } catch (Exception $e) {
            Log::error("Erro ao carregar as tarefas:{$e->getMessage()} | Linha: {$e->getLine()} | Trace: {$e->getTraceAsString()}");
            return view('errors.exception');
        }
    }

    /**
     * Summary of criarTarefas
     * @param mixed $request
     * @return void
     */
    public function criarTarefas($request)
    {
        try {
            DB::beginTransaction();

            $titulo = (string) $request->input('titulo');
            $descricao = (string) $request->input('descricao');
            $status = $request->input('status');
            $prioridadeTarefa = $request->input('prioridade');
            $userId = (integer) Auth::id();
            $data = Carbon::parse($request->input('data_vencimento') . ' ' . now()->format('H:i:s'));


            $tarefa = $this->listaTarefas->create([
                'titulo' => $titulo,
                'descricao' => $descricao,
                'data_de_vencimento' => $data,
                'prioridade' => $prioridadeTarefa,
                'status' => $status,
                'user_id' => $userId,
            ]);
            DB::commit();

            $emailData = [
                'tarefa' => $tarefa,
                'user_id' => $userId,
            ];

            EnviarEmail::dispatch($emailData);
            event(new PusherEvent($tarefa));
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Erro ao criar tarefa: {$e->getMessage()}");
            throw $e;
        }

    }

    /**
     * Summary of buscaUsuario
     * @return \Illuminate\Database\Eloquent\Collection<int, User>
     */
    public function buscaUsuario()
    {
        try {
            return $this->usuarioTarefa->select('id', 'name')
                ->get();
        } catch (Exception $e) {
            Log::error("Erro ao buscar usuarios cadastrados: {$e->getMessage()}");
            throw $e;
        }
    }

    /**
     * Summary of buscarTarefa
     * @param mixed $tarefaId
     * @return ListaTarefas|null
     */
    public function buscarTarefa($tarefaId)
    {
        try {
            return $this->listaTarefas->select('id', 'titulo', 'descricao', 'status', 'data_de_vencimento', 'prioridade')
                ->where('id', $tarefaId)
                ->first();

        } catch (Exception $e) {
            Log::error("Erro ao carregar os dados para edicao: {$e->getMessage()}");
            throw $e;
        }

    }

    /**
     * Summary of atualizaTarefa
     * @param mixed $request
     * @param mixed $tarefa
     * @return void
     */
    public function atualizaTarefa($request, $tarefa)
    {
        try {
            DB::beginTransaction();

            $tarefaStatusUpdate = (string) $request->input('status');
            $titulo = (string) $request->input('titulo');
            $descricao = (string) $request->input('descricao');
            $dataValidade = Carbon::parse($request->input('data_vencimento') . ' ' . now()->format('H:i:s'));
            $prioridade = $request->input('prioridade');

            $tarefa->update([
                'titulo' => $titulo,
                'descricao' => $descricao,
                'status' => $tarefaStatusUpdate,
                'data_de_vencimento' => $dataValidade,
                'alerta_enviado' => 0,
                'prioridade' => $prioridade,
            ]);
            DB::commit();
            event(new PusherEvent($tarefa));

        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Erro ao atualizar a tarefa: {$e->getMessage()}");
            throw $e;
        }
    }

    /**
     * Summary of buscaTarefaDeletada
     * @return \Illuminate\Database\Eloquent\Collection<int, ListaTarefas>|\Illuminate\Database\Eloquent\Collection<int, mixed>
     */
    public function buscaTarefaDeletada()
    {
        try {
            $usuarioAutenticado = Auth::user();
                
            return $this->listaTarefas->where('user_id', Auth::id())->whereNotNull('deleted_at')
                ->when($usuarioAutenticado->tipo_usuario == 'administrador', function ($query) {
                    return $query->orWhere('user_id','>=',1)->whereNotNull('deleted_at');
                })
                ->withTrashed()
                ->get();

        } catch (Exception $e) {
            Log::error("Erro ao carregar tarefas deletadas: {$e->getMessage()}");
            throw $e;
        }


    }

    /**
     * Summary of deletarTarefa
     * @param mixed $id
     * @return void
     */
    public function deletarTarefa($id)
    {
        try {
            DB::beginTransaction();

            $tarefa = $this->listaTarefas->withTrashed()->findOrFail($id);

            if ($tarefa->trashed()) {
                $tarefa->forceDelete();
            } else {
                $tarefa->delete();
            }

            DB::commit();
            event(new PusherEvent($tarefa));
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Erro ao deletar a tarefa {$e->getMessage()}");
            throw $e;
        }

    }

    /**
     * Summary of restaurarTarefa
     * @param mixed $id
     * @return void
     */
    public function restaurarTarefa($id)
    {
        try {
            DB::beginTransaction();

            $tarefa = $this->listaTarefas->withTrashed()->findOrFail($id);

            $tarefa->restore();

            DB::commit();
            event(new PusherEvent($tarefa));

        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Erro ao restaurar a tarefa: {$e->getMessage()}");
            throw $e;
        }

    }

    /**
     * Summary of filtraTarefaPorCampo
     * @param string $campo
     * @param array $valores
     * @param int $userId
     * @return int[]
     */
    public function filtraTarefaPorCampo(string $campo, array $valores, int $userId): array
    {
        try {
            $totais = [];

            foreach ($valores as $valor) {
                $totais[$valor] = $this->listaTarefas
                    ->where('user_id', $userId)
                    ->where($campo, $valor)
                    ->count();
            }

            return $totais;
        } catch (Exception $e) {
            Log::error("Erro ao buscar tarefas pelo filtro fornecido: {$e->getMessage()}");
            throw $e;
        }
    }

    /**
     * Summary of filtraTarefaEnviadas
     * @return \Illuminate\Database\Eloquent\Collection<int, ListaTarefas>
     */
    public function filtraTarefaEnviadas()
    {
        try {
            $userId = Auth::id();

            return $this->listaTarefas->where('alerta_enviado', 1)->where('user_id', $userId)->get();
        } catch (Exception $e) {
            Log::error("Erro ao filtrar usuarios com alerta ja recebidos: {$e->getMessage()}");
            throw $e;
        }
    }
}
