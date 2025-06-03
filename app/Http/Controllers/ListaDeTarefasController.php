<?php

namespace App\Http\Controllers;
use App\Http\Requests\AtualizaTarefasRequest;
use App\Http\Requests\CriacaoDeTarefasRequest;
use App\Models\ListaTarefas;
use Illuminate\Http\Request;
use Auth;
use Exception;
use Illuminate\Support\Facades\Log;

class ListaDeTarefasController extends Controller
{
    private $listaTarefas;
    public function __construct(ListaTarefas $listaTarefas)
    {
        $this->listaTarefas = $listaTarefas;
    }

    /**
     * Método com as regras de validação.
     *
     * Summary of index
     * @param array $indexTarefas - Executa a consulta para obter todas as tarefas.
     *
     * @return bool
     */

    public function index()
    {
        try {
            $indexTarefas = $this->listaTarefas->select('id', 'titulo', 'descricao', 'status', 'created_at', 'deleted_at', 'user_id')
                ->where('user_id', Auth::id())->withTrashed()->get();

            return view('dashboard', @compact('indexTarefas'));
        } catch (Exception $e) {
            $message = $e->getMessage();
            Log::error("Erro ao carregar as tarefas:{$e->getMessage()} | Linha: {$e->getLine()} | Trace: {$e->getTraceAsString()}");
            echo $message;
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
     * @param $create - Recebe os dados da requisição para criar a vaga.
     * @param \Illuminate\Http\Request $request
     * @return void
     */

    public function store(CriacaoDeTarefasRequest $request)
    {
        try {
            $create = $this->listaTarefas->create([
                'titulo' => $request->input('titulo'),
                'descricao' => $request->input('descricao'),
                'user_id' => Auth::id(),
            ]);

            return redirect()->route('dashboard')->with('success', 'Permissões do usuário alterada com sucesso.');
        } catch (Exception $e) {
            $message = $e->getMessage();
            Log::error("Erro ao executar a criação da tarefa:{$e->getMessage()} | Linha: {$e->getLine()} | Trace: {$e->getTraceAsString()}");
            echo $message;
        }
    }
    /**
     * Summary of edit
     * @param $editTarefa - Identifica a vaga pelo id para que seja possivel atualizar as informações.
     * @param mixed $id - Obtém da requisição o ID da vaga.
     * @return void
     */

    public function edit($id)
    {
        try {
            $editTarefa = $this->listaTarefas->select('id', 'titulo', 'descricao')->where('id', $id)->first();
            return view('listaTarefas.editTarefas', @compact('editTarefa'));
        } catch (Exception $e) {
            $message = $e->getMessage();
            Log::error("Erro ao carregar os dados para edição da tarefa:{$e->getMessage()} | Linha: {$e->getLine()} | Trace: {$e->getTraceAsString()}");
            echo $message;
        }

    }
    /**
     * Summary of update
     * @param string $titulo - Armazena o título da vaga que será atualizado pela requisição.
     * @param string $descricao - Armazena a descricao da vaga que será atualizado pela requisição.
     * @param mixed  $storeTarefa - Atualiza as colunas com os valores das variáveis definidas..
     * @return void
     */

    public function update(AtualizaTarefasRequest $request, $id)
    {
        try {
            $titulo = $request->input('titulo');
            $descricao = $request->input('descricao');

            $tarefaStatusUpdate = 'concluida';
            $storeTarefa = $this->listaTarefas->select('id', 'titulo', 'descricao')
                ->where('id', $id)->update([
                        'titulo' => $titulo,
                        'descricao' => $descricao,
                        'status' => $tarefaStatusUpdate,
                        'user_id' => Auth::id(),
                    ]);
            return redirect()->route('dashboard');
        } catch (Exception $e) {
            $message = $e->getMessage();
            Log::error("Erro ao realizar a edição da tarefa:{$e->getMessage()} | Linha: {$e->getLine()} | Trace: {$e->getTraceAsString()}");
            echo $message;
        }
    }
    /**
     * Summary of delete
     * @return void
     */

    public function delete()
    {

    }
    /**
     * Summary of destroy
     * @return void
     */

    public function destroy($id)
    {
        try {
            $tarefa = ListaTarefas::withTrashed()->findOrFail($id);

            if ($tarefa->trashed()) {
                $tarefa->forceDelete();

                return redirect()->route('tarefas.index');
            } else {
                $tarefa->delete();

                return redirect()->route('tarefas.index');
            }
        } catch (Exception $e) {
            $message = $e->getMessage();
            Log::error("Erro ao processar a exclusão da tarefa:{$e->getMessage()} | Linha: {$e->getLine()} | Trace: {$e->getTraceAsString()}");
            echo $message;
        }
    }
    public function restore($id)
    {
        try {
            $tarefa = $this->listaTarefas->withTrashed()->find($id);
            $tarefa->restore();

            $statusTarefaPadrao = 'pendente';
            $atualizaTarefa = $this->listaTarefas->select('id', 'status')->where('id', $id)->update([
                'status' => $statusTarefaPadrao,
            ]);

            return redirect()->route('dashboard');
        } catch (Exception $e) {
            $message = $e->getMessage();
            Log::error("Erro ao tentar restaurar a tarefa excluida:{$e->getMessage()} | Linha: {$e->getLine()} | Trace: {$e->getTraceAsString()}");
            echo $message;
        }
    }
}
