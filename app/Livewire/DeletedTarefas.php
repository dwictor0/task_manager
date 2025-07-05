<?php

namespace App\Livewire;

use App\Services\TarefasService;
use Livewire\Component;

class DeletedTarefas extends Component
{
    public $tarefasDeletada;

    /**
     * Summary of mount
     * @param \App\Services\TarefasService $tarefasService
     * @return void
     */
    public function mount(TarefasService $tarefasService)
    {
      $this->tarefasDeletada = $tarefasService->buscaTarefaDeletada();
    }
    
    /**
     * Summary of render
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.deleted-tarefas',['index' => $this->tarefasDeletada]);
    }

}
