<?php

namespace App\Livewire;

use App\Services\TarefasService;
use Livewire\Component;

class DeletedTarefas extends Component
{
    public $tarefasDeletada;
    public function mount(TarefasService $tarefasService)
    {
      $this->tarefasDeletada = $tarefasService->buscaTarefaDeletada();
    }
    
    public function render()
    {
        return view('livewire.deleted-tarefas',['index' => $this->tarefasDeletada]);
    }

}
