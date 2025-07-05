<?php

namespace App\Livewire;

use App\Services\TarefasService;
use Livewire\Component;

class EditTarefas extends Component
{
    public $tarefa;
    public $id;

    /**
     * Summary of render
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.edit-tarefas',['tarefa' => $this->tarefa]);
    }

    /**
     * Summary of mount
     * @param \App\Services\TarefasService $tarefasService
     * @param mixed $id
     * @return void
     */
    public function mount(TarefasService $tarefasService,$id)
    {

        $this->tarefa = $tarefasService->buscarTarefa($id);
    }
}
