<?php

namespace App\Http\Controllers;
use App\Http\Requests\AtualizaTarefasRequest;
use App\Http\Requests\CriacaoDeTarefasRequest;
use Illuminate\Contracts\View\View;
use App\ListaDeTarefasInterface;
use Illuminate\Http\RedirectResponse;
use App\Models\ListaTarefas;
use App\Services\TarefasService;
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
    private TarefasService $tarefasService;

    /**
     * Método __construct
     * @author dwictor0
     * @param ListaTarefas $listaTarefas
     */
    public function __construct (ListaTarefas $listaTarefas,TarefasService $tarefasService)
    {
        $this->listaTarefas = $listaTarefas;
        $this->tarefasService = $tarefasService;
    }

    /**
     * Método Index
     * @return View
     * @author dwictor0
     */
    public function index (): View
    {
        $tarefas = $this->tarefasService->indexTarefas();

        return view('dashboard', @compact('tarefas'));
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
     * @param CriacaoDeTarefasRequest $request
     * @return View|Redirect
     */
    public function store (CriacaoDeTarefasRequest $request): View|RedirectResponse
    {
        try {
            DB::beginTransaction();
            
            $this->tarefasService->criarTarefas($request);

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
            $tarefa = $this->tarefasService->buscarTarefa($tarefaId);
       
        
            return view('listaTarefas.editTarefas', compact('tarefa'));
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

            $this->tarefasService->atualizaTarefa($request,$tarefa);

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
            $index = $this->tarefasService->buscaTarefaDeletada();
            
            return view('listaTarefas.deletedTarefas', @compact('index'));
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
             
            $this->tarefasService->deletarTarefa($id);

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

            $this->tarefasService->restaurarTarefa($id);

            DB::commit();

            return redirect()->route('dashboard')->with('success', 'A tarefa foi restaurada com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Erro ao tentar restaurar a tarefa excluida:{$e->getMessage()} | Linha: {$e->getLine()} | Trace: {$e->getTraceAsString()}");
            return view('errors.exception');
        }
    }
}
