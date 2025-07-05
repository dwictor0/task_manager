<?php

namespace App\Livewire;

use App\Models\ListaTarefas;
use App\Services\TarefasService;
use Livewire\Component;

class DashboardContainer extends Component
{
    public $tarefas;

    public function render()
    {
        return view('livewire.dashboard-container', ['tarefas' => $this->tarefas]);
    }

    public function mount(TarefasService $tarefas)
    {
        $this->tarefas = $tarefas->indexTarefas();

    }
}
