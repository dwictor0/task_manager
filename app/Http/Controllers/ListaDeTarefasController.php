<?php

namespace App\Http\Controllers;
use App\Http\Requests\AtualizaTarefasRequest;
use App\Http\Requests\CriacaoDeTarefasRequest;
use App\ListaDeTarefasInterface;
use App\Models\ListaTarefas;
use Illuminate\Http\Request;
use Auth;
use Exception;
use Illuminate\Support\Facades\Log;

class ListaDeTarefasController extends Controller implements ListaDeTarefasInterface
{

    /**
     * Summary of listaTarefas
     * @var 
     */
    private $listaTarefas;
    
    /**
     * Summary of __construct
     * @param \App\Models\ListaTarefas $listaTarefas
     */
    public function __construct(ListaTarefas $listaTarefas)
    {
        $this->listaTarefas = $listaTarefas;
    }

    /**
     * Summary of index
     * @param object $indexTarefas - Executa a consulta para obter todas as tarefas.
     * @param integer $userId 
     * @return bool
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
     * Summary of create
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('listaTarefas.createTarefas');
    }

    /**
     * Summary of store
     * @param string $titulo
     * @param string $descricao
     * @param integer $userId
     * @param object $create - Recebe os dados da requisição para criar a vaga.
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function store(CriacaoDeTarefasRequest $request)
    {
        try {
            $titulo = (string) $request->input('titulo');
            $descricao = (string) $request->input('descricao');
            $userId = (integer) Auth::id();

            $create = (object) $this->listaTarefas->create([
                'titulo' => $titulo,
                'descricao' => $descricao,
                'user_id' => $userId,
            ]);

            return redirect()->route('dashboard')->with('success', 'Permissões do usuário alterada com sucesso.');
        } catch (Exception $e) {
            $message = $e->getMessage();
            Log::error("Erro ao executar a criação da tarefa:{$e->getMessage()} | Linha: {$e->getLine()} | Trace: {$e->getTraceAsString()}");
            return view('errors.exception',@compact('message'));
        }
    }

    /**
     * Summary of edit
     * @param object $editTarefa - Identifica a vaga pelo id para que seja possivel atualizar as informações.
     * @param integer $id - Obtém da requisição o ID da vaga.
     * @return void
     */
    public function edit(ListaTarefas $tarefa)
    {
        try {
            $tarefa = (object) $this->listaTarefas->select('id', 'titulo', 'descricao')->where('id', $tarefa->id)->first();
            return view('listaTarefas.editTarefas', @compact('tarefa'));
        } catch (Exception $e) {
            $message = $e->getMessage();
            Log::error("Erro ao carregar os dados para edição da tarefa:{$e->getMessage()} | Linha: {$e->getLine()} | Trace: {$e->getTraceAsString()}");
            return view('errors.exception',@compact('message'));
        }

    }

    /**
     * Summary of update
     * @param string $titulo - Armazena o título da vaga que será atualizado pela requisição.
     * @param string $descricao - Armazena a descricao da vaga que será atualizado pela requisição.
     * @param integer $userId
     * @param string $tarefaStatusUpdate 
     * @param object $storeTarefa - Atualiza as colunas com os valores das variáveis definidas..
     * @return void
     */
    public function update(AtualizaTarefasRequest $request,ListaTarefas $tarefa)
    {
        try {
            $titulo = (string) $request->input('titulo');
            $descricao = (string) $request->input('descricao');
            $userId = (integer) Auth::id();

            $tarefaStatusUpdate = (string) 'concluida';
            $tarefa->where('id', $tarefa->id)->update([
                        'titulo' => $titulo,
                        'descricao' => $descricao,
                        'status' => $tarefaStatusUpdate,
                        'user_id' => $userId,
                    ]);
            return redirect()->route('dashboard');
        } catch (Exception $e) {
            $message = $e->getMessage();
            Log::error("Erro ao realizar a edição da tarefa:{$e->getMessage()} | Linha: {$e->getLine()} | Trace: {$e->getTraceAsString()}");
            return view('errors.exception',@compact('message'));
        }
    }

    /**
     * Summary of delete
     * @return \Illuminate\Contracts\View\View
     */
    public function delete()
    {

    }

    /**
     * Summary of destroy
     * 
     * @param integer $id
     * @param object $tarefa
     * @return void
     */
    public function destroy($id)
    {
        try {
            $tarefa = (object) $this->listaTarefas->withTrashed()->findOrFail($id);

            if ($tarefa->trashed()) {
                $tarefa->forceDelete();

                return redirect()->route('tarefas.index');
            } 
                $tarefa->delete();
                
                return redirect()->route('tarefas.index');
                
        } catch (Exception $e) {
            $message = $e->getMessage();
            Log::error("Erro ao processar a exclusão da tarefa:{$e->getMessage()} | Linha: {$e->getLine()} | Trace: {$e->getTraceAsString()}");
            return view('errors.exception',@compact('message'));
        }
    }
    
    /**
     * Summary of restore
     * @param integer $id
     * @param object $tarefa
     * @param string $statusTarefaPadrao
     * @param boolean $atualizaTarefa
     * @return mixed|\Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        try {
            $tarefa = (object) $this->listaTarefas->withTrashed()->find($id);
            $tarefa->restore();

            $statusTarefaPadrao = (string) 'pendente';
            $atualizaTarefa = $this->listaTarefas->select('id', 'status')->where('id', $id)->update([
                'status' => $statusTarefaPadrao,
            ]);

            return redirect()->route('dashboard');
        } catch (Exception $e) {
            $message = $e->getMessage();
            Log::error("Erro ao tentar restaurar a tarefa excluida:{$e->getMessage()} | Linha: {$e->getLine()} | Trace: {$e->getTraceAsString()}");
            return view('errors.exception',@compact('message'));
        }
    }
}
