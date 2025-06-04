<?php

namespace App\Http\Controllers;
use App\Http\Requests\AtualizaTarefasRequest;
use App\Http\Requests\CriacaoDeTarefasRequest;
use App\ListaDeTarefasInterface;
use App\Models\ListaTarefas;
use Auth;
use Exception;
use Illuminate\Support\Facades\Log;
use DB;

class ListaDeTarefasController extends Controller implements ListaDeTarefasInterface
{

    /**
     * Summary of $listaTarefas
     * @author dwictor0 
     * @var $listaTarefas
     */
    private $listaTarefas;
    
    /**
     * Método __construct
     * @author dwictor0 
     * @param \App\Models\ListaTarefas $listaTarefas
     */
    public function __construct(ListaTarefas $listaTarefas)
    {
        $this->listaTarefas = $listaTarefas;
    }

    /**
     * Método index
     * @author dwictor0 
     * @param object $indexTarefas - Executa a consulta para obter todas as tarefas.
     * @param integer $userId - ID do usuario que está visualizando as tarefas.
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        try {
            $userId = (integer) Auth::id();
            $indexTarefas = (object) $this->listaTarefas->where('user_id', Auth::id())->get();

            return view('dashboard', @compact('indexTarefas'));
        } catch (Exception $e) {
            $message = $e->getMessage();
            Log::error("Erro ao carregar as tarefas:{$e->getMessage()} | Linha: {$e->getLine()} | Trace: {$e->getTraceAsString()}");
            return view('errors.exception',@compact('message'));
        }

    }
    
    /**
     * Método create
     * @author dwictor0 
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('listaTarefas.createTarefas');
    }

    /**
     * Método store
     * @author dwictor0 
     * @param \App\Http\Requests\CriacaoDeTarefasRequest $request
     * @param string $titulo - Titulo da tarefa que está sendo criada.
     * @param string $descricao - Descricao fornecida na criação da tarefa
     * @param integer $userId - ID do usuario que realizou a criação da tarefa.
     * @param object $create - Recebe os dados da requisição para criar a vaga.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function store(CriacaoDeTarefasRequest $request)
    {
        try {
            DB::beginTransaction();
            $titulo = (string) $request->input('titulo');
            $descricao = (string) $request->input('descricao');
            $userId = (integer) Auth::id();
            
            DB::commit();
            $create = (object) $this->listaTarefas->create([
                'titulo' => $titulo,
                'descricao' => $descricao,
                'user_id' => $userId,
            ]);

            return redirect()->route('dashboard')->with('success', 'Tarefa criada com sucesso!.');
        } catch (Exception $e) {
            $message = $e->getMessage();
            Log::error("Erro ao executar a criação da tarefa:{$e->getMessage()} | Linha: {$e->getLine()} | Trace: {$e->getTraceAsString()}");
            DB::rollBack();
            return view('errors.exception',@compact('message'));
        }
    }

    /**
     * Método edit
     * @author dwictor0 
     * @param \App\Models\ListaTarefas $tarefa
     * @param object $editTarefa - Identifica a vaga pelo id para que seja possivel atualizar as informações.
     * @param integer $tarefa - Identifica a tarefa através do id da requisição para que seja possivel realizar a atualização.
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(ListaTarefas $tarefa)
    {
        try {
            $tarefa = (object) $this->listaTarefas->select('id', 'titulo', 'descricao','status')->where('id', $tarefa->id)->first();
            return view('listaTarefas.editTarefas', @compact('tarefa'));
        } catch (Exception $e) {
            $message = $e->getMessage();
            Log::error("Erro ao carregar os dados para edição da tarefa:{$e->getMessage()} | Linha: {$e->getLine()} | Trace: {$e->getTraceAsString()}");
            return view('errors.exception',@compact('message'));
        }

    }

    /**
     * Método update
     * @author dwictor0
     * @param \App\Http\Requests\AtualizaTarefasRequest $request
     * @param \App\Models\ListaTarefas $tarefa
     * @param string $titulo - Título da tarefa recebido pela requisição.
     * @param string $descricao - Texto atualizado da descrição conforme valor da requisição.
     * @param string $tarefaStatusUpdate - Status da tarefa obtido pela requisição
     * @param integer $userId - ID do usuario que está realizando a atualização.
     * @param object $storeTarefa - Atualiza as colunas com os valores das variáveis definidas.
     * @return mixed|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function update(AtualizaTarefasRequest $request,ListaTarefas $tarefa)
    {
        try {
            DB::beginTransaction();
            $tarefaStatusUpdate = (string) $request->input('status');
            $titulo = (string) $request->input('titulo');
            $descricao = (string) $request->input('descricao');
            $userId = (integer) Auth::id();

            DB::commit();
            $tarefa->where('id', $tarefa->id)->update([
                        'titulo' => $titulo,
                        'descricao' => $descricao,
                        'status' => $tarefaStatusUpdate,
                        'user_id' => $userId,
                    ]);
                    
            return redirect()->route('dashboard')->with('success','Tarefa atualizada!');
        } catch (Exception $e) {
            $message = $e->getMessage();
            Log::error("Erro ao realizar a edição da tarefa:{$e->getMessage()} | Linha: {$e->getLine()} | Trace: {$e->getTraceAsString()}");
            DB::rollBack();
            return view('errors.exception',@compact('message'));
        }
    }

    /** 
     * Método delete
     * @author dwictor0 
     * @param $indexTarefasDeleted - Pega todas as tarefas que estão com soft-delete.
     * @return \Illuminate\Contracts\View\View
     */
    public function delete()
    {
        try {
            $indexTarefasDeleted = (object) $this->listaTarefas
            ->where('user_id', Auth::id())
            ->whereNotNull('deleted_at')
            ->withTrashed()->get();
      
            return view('listaTarefas.deletedTarefas',@compact('indexTarefasDeleted'));
        } catch (Exception $e) {
            $message = $e->getMessage();
            Log::error("Erro ao listar as tarefas excluidas:{$e->getMessage()} | Linha: {$e->getLine()} | Trace: {$e->getTraceAsString()}");
            return view('errors.exception',@compact('message'));
        }
    }

    /**
     * Método destroy
     * @author dwictor0 
     * @param integer $id - Armazena o ID da tarefa da requisição.
     * @param object $tarefa - Busca a tarefa da requisição para aplicar soft delete ou exclusão permanente conforme a condicional.
     * @return void
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $tarefa = (object) $this->listaTarefas->withTrashed()->findOrFail($id);

            if ($tarefa->trashed()) {
                $tarefa->forceDelete();
            } 
            DB::commit();
                $tarefa->delete();
                
                return redirect()->route('dashboard')->with('success','Tarefa deletada com sucesso!');               
        } catch (Exception $e) {
            $message = $e->getMessage();
            Log::error("Erro ao processar a exclusão da tarefa:{$e->getMessage()} | Linha: {$e->getLine()} | Trace: {$e->getTraceAsString()}");
            DB::rollBack();
            return view('errors.exception',@compact('message'));
        }
    }
    
    /**
     * Método restore
     * @author dwictor0 
     * @param integer $id - Armazena o ID da tarefa da requisição.
     * @param object $tarefa - Busca a tarefa pelo ID, incluindo as com soft-delete
     * @return \Illuminate\Http\RedirectResponse 
     */
    public function restore($id)
    {
        try {
            DB::beginTransaction();
            
            $tarefa = (object) $this->listaTarefas->withTrashed()->find($id);
            $tarefa->restore();

            DB::commit();

            return redirect()->route('dashboard')->with('success','A tarefa foi restaurada com sucesso!');
        } catch (Exception $e) {
            $message = $e->getMessage();
            Log::error("Erro ao tentar restaurar a tarefa excluida:{$e->getMessage()} | Linha: {$e->getLine()} | Trace: {$e->getTraceAsString()}");
            DB::rollBack();
            return view('errors.exception',@compact('message'));
        }
    }
}
