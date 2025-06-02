<?php

namespace App\Http\Controllers;

use App\Models\ListaTarefas;
use Illuminate\Http\Request;

class ListaDeTarefasController extends Controller
{
    public function __construct(ListaTarefas $listaTarefas){
      $this->listaTarefas = $listaTarefas;
    }
    /**
     * Summary of index
     * @return void
     */

    public function index(){
        $indexTarefas = $this->listaTarefas->select('id','titulo','descricao')->get();
        return view('dashboard',@compact('indexTarefas'));
    }
    /**
     * Summary of create
     * @return void
     */

    public function create(){
          return view('listaTarefas.createTarefas');
    }
    /**
     * Summary of store
     * @param \Illuminate\Http\Request $request
     * @return void
     */

    public function store(Request $request){
        $create = $this->listaTarefas->create($request->all());
        return redirect()->route('dashboard')->with('success', 'Permissões do usuário alterada com sucesso.');
    }
    /**
     * Summary of edit
     * @param mixed $id
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
     * @return void
     */

    public function update(Request $request){
        $titulo = $request->input('titulo');
        $descricao = $request->input('descricao');
         $storeTarefa = $this->listaTarefas->select('id','titulo','descricao')
        ->where('id',$id)->update([
            'titulo' => $titulo, 
            'descricao' => $descricao
        ]);
         return redirect()->route('listadetarefas.index')->with('success', 'Permissões do usuário alterada com sucesso.');
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
