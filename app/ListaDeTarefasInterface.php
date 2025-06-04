<?php

namespace App;

interface ListaDeTarefasInterface
{
    public function index();
    public function create();
    public function store(\App\Http\Requests\CriacaoDeTarefasRequest $request);
    public function edit(\App\Models\ListaTarefas $tarefa);
    public function update(\App\Http\Requests\AtualizaTarefasRequest $request, \App\Models\ListaTarefas $tarefa);
    public function delete();
    public function destroy($id);
    public function restore($id);
}
