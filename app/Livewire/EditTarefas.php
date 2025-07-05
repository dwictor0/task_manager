<?php

namespace App\Livewire;

use App\Services\TarefasService;
use Livewire\Component;

class EditTarefas extends Component
{
    public $tarefa;
    public $id;

    public function render()
    {
        return view('livewire.edit-tarefas',['tarefa' => $this->tarefa]);
    }

    public function mount(TarefasService $tarefasService,$id)
    {

        $this->tarefa = $tarefasService->buscarTarefa($id);
    }
}
