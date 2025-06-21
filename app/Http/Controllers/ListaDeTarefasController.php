<?php

namespace App\Http\Controllers;
use App\Http\Requests\AtualizaTarefasRequest;
use App\Http\Requests\AtualizaTarefasRequest as AtualizaTarefasRequestAlias;
use App\Http\Requests\CriacaoDeTarefasRequest as CriacaoDeTarefasRequestAlias;
use App\Models\ListaTarefas as ListaTarefasAlias;
use App\Http\Requests\CriacaoDeTarefasRequest;
use Illuminate\Contracts\View\View;
use App\ListaDeTarefasInterface;
use Illuminate\Http\RedirectResponse;
use App\Models\ListaTarefas;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Exception;
use DB;
use Auth;

class ListaDeTarefasController extends Controller implements ListaDeTarefasInterface
{

    /**
     * @var ListaTarefas
     */
    private ListaTarefas $listaTarefas;

    /**
     * Método __construct
     * @author dwictor0
     * @param ListaTarefas $listaTarefas
     */
    public function __construct (ListaTarefas $listaTarefas)
    {
        $this->listaTarefas = $listaTarefas;
    }

    /**
     * Método Index
     * @return View
     * @author dwictor0
     */
    public function index (): View
    {
        try {
            $userId = (integer)Auth::id();
            $indexTarefas = $this->listaTarefas->where('user_id', $userId)->get();

            return view('dashboard', @compact('indexTarefas'));
        } catch (Exception $e) {
            Log::error("Erro ao carregar as tarefas:{$e->getMessage()} | Linha: {$e->getLine()} | Trace: {$e->getTraceAsString()}");
            return view('errors.exception');
        }

    }

    /**
     * Método Create
     * @return View
     * @author dwictor0
     */
    public function create (): View
    {
        return view('listaTarefas.createTarefas');
    }

    /**
     * Método Store
     * @author dwictor0
     * @param CriacaoDeTarefasRequestAlias $request
     * @return View|Redirect
     */
    public function store (CriacaoDeTarefasRequest $request): View|RedirectResponse
    {
        try {
            DB::beginTransaction();
            $titulo = (string) $request->input('titulo');
            $descricao = (string)$request->input('descricao');
            $userId = (integer)Auth::id();

            $this->listaTarefas->create([
                'titulo' => $titulo,
                'descricao' => $descricao,
                'user_id' => $userId,
            ]);

            DB::commit();

            return redirect()->route('dashboard')->with('success', 'Tarefa criada com sucesso!.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Erro ao executar a criação da tarefa:{$e->getMessage()} | Linha: {$e->getLine()} | Trace: {$e->getTraceAsString()}");
            return view('errors.exception');
        }
    }


    /**
     * Método Edit
     * @author dwictor0
     * @param ListaTarefasAlias $tarefa
     * @return View
     */
    public function edit (ListaTarefas $tarefa): View
    {
        try {
            $tarefaId = $tarefa->id;
            $tarefa = $this->listaTarefas->select('id', 'titulo', 'descricao', 'status')
             ->where('id',$tarefaId)
             ->first();
            return view('listaTarefas.editTarefas', @compact('tarefa'));
        } catch (Exception $e) {
            Log::error("Erro ao carregar os dados para edição da tarefa:{$e->getMessage()} | Linha: {$e->getLine()} | Trace: {$e->getTraceAsString()}");
            return view('errors.exception');
        }

    }

    /**
     * Método Update
     * @author dwictor0
     * @param AtualizaTarefasRequestAlias $request
     * @param ListaTarefasAlias $tarefa
     * @return View|RedirectResponse
     */
    public function update (AtualizaTarefasRequest $request, ListaTarefas $tarefa): View|RedirectResponse
    {
        try {
            DB::beginTransaction();

            $tarefaStatusUpdate = (string)$request->input('status');
            $titulo = (string)$request->input('titulo');
            $descricao = (string)$request->input('descricao');
            $userId = (integer)Auth::id();

            $tarefa->update([
                'titulo' => $titulo,
                'descricao' => $descricao,
                'status' => $tarefaStatusUpdate,
                'user_id' => $userId,
            ]);

            DB::commit();

            return redirect()->route('dashboard')->with('success', 'Tarefa atualizada!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Erro ao realizar a edição da tarefa:{$e->getMessage()} | Linha: {$e->getLine()} | Trace: {$e->getTraceAsString()}");
            return view('errors.exception');
        }
    }

    /**
     * Método IndexSoftDelete
     * @author dwictor0 
     * @return View
     */
    public function IndexSoftDelete (): View
    {
        try {
            $indexTarefasDeleted = $this->listaTarefas
                ->where('user_id', Auth::id())
                ->whereNotNull('deleted_at')
                ->withTrashed()->get();

            return view('listaTarefas.deletedTarefas', @compact('indexTarefasDeleted'));
        } catch (Exception $e) {
            Log::error("Erro ao listar as tarefas excluidas:{$e->getMessage()} | Linha: {$e->getLine()} | Trace: {$e->getTraceAsString()}");
            return view('errors.exception');
        }
    }

    /**
     * Método Destroy
     * @param $id
     * @author dwictor0 
     * @return View|RedirectResponse
     */
    public function destroy ($id): View|RedirectResponse
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

            return redirect()->route('dashboard')->with('success', 'Tarefa deletada com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Erro ao processar a exclusão da tarefa:{$e->getMessage()} | Linha: {$e->getLine()} | Trace: {$e->getTraceAsString()}");
            return view('errors.exception');
        }
    }

    /**
     * Método Restore
     * @param integer $id - Armazena o ID da tarefa da requisição.
     * @return View|RedirectResponse
     * @author dwictor0
     */
    public function restore ($id): View|RedirectResponse
    {
        try {
            DB::beginTransaction();

            $tarefa = $this->listaTarefas->withTrashed()->findOrFail($id);
            $tarefa->restore();

            DB::commit();

            return redirect()->route('dashboard')->with('success', 'A tarefa foi restaurada com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Erro ao tentar restaurar a tarefa excluida:{$e->getMessage()} | Linha: {$e->getLine()} | Trace: {$e->getTraceAsString()}");
            return view('errors.exception');
        }
    }
}
