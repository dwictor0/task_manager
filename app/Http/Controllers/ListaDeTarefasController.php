<?php

namespace App\Http\Controllers;

use App\Models\ListaTarefas;
use Illuminate\Http\Request;
use Auth;

class ListaDeTarefasController extends Controller
{
    public function __construct(ListaTarefas $listaTarefas){
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

    public function index(){
        $indexTarefas = $this->listaTarefas->select('id','titulo','descricao','status')->get();
        return view('dashboard',@compact('indexTarefas'));
    }
    /**
     * Summary of create
     * @return \Illuminate\Contracts\View\View
     */

    public function create(){
          return view('listaTarefas.createTarefas');
    }
    /**
     * Summary of store
     * @param $create - Recebe os dados da requisição para criar a vaga.
     * @param \Illuminate\Http\Request $request
     * @return void
     */

    public function store(Request $request){
        $create = $this->listaTarefas->create([
            'titulo' => $request->input('titulo'),
            'descricao'=> $request->input('descricao'),
            'user_id'=> Auth::id(),
        ]);
        return redirect()->route('index.tarefas')->with('success', 'Permissões do usuário alterada com sucesso.');
    }
    /**
     * Summary of edit
     * @param $editTarefa - Identifica a vaga pelo id para que seja possivel atualizar as informações.
     * @param mixed $id - Obtém da requisição o ID da vaga.
     * @return void
     */

    public function edit($id){
      $editTarefa = $this->listaTarefas->select('id','titulo','descricao')
      ->where('id',$id)
      ->first();
      return view('listaTarefas.editTarefas',@compact('editTarefa'));
    }
    /**
     * Summary of update
     * @param string $titulo - Armazena o título da vaga que será atualizado pela requisição.
     * @param string $descricao - Armazena a descricao da vaga que será atualizado pela requisição.
     * @param mixed  $storeTarefa - Atualiza as colunas com os valores das variáveis definidas..
     * @return void
     */

    public function update(Request $request,$id){
        $titulo = $request->input('titulo');
        $descricao = $request->input('descricao');
         $storeTarefa = $this->listaTarefas->select('id','titulo','descricao')
        ->where('id',$id)->update([
            'titulo' => $titulo, 
            'descricao' => $descricao,
            'user_id' => Auth::id(),
        ]);
         return redirect()->route('index.tarefas')->with('success', 'Permissões do usuário alterada com sucesso.');
    }
    /**
     * Summary of delete
     * @return void
     */

    public function delete(){

    }
    /**
     * Summary of destroy
     * @return void
     */

    public function destroy(){

    }
}
