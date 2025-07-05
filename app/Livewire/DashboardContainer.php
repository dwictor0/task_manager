<?php

namespace App\Livewire;

use App\Models\ListaTarefas;
use App\Services\TarefasService;
use Livewire\Component;

class DashboardContainer extends Component
{
    public $tarefas;

    protected $listeners = ['evento' => 'atualizarTarefas'];

    protected $tarefasService;

    public function mount(TarefasService $tarefas)
    {
        $this->tarefasService = $tarefas;
        $this->atualizarTarefas();
    }


    public function atualizarTarefas()
    {
        $this->tarefas = app(\App\Services\TarefasService::class)->indexTarefas();
    }


    public function render()
    {
        return view('livewire.dashboard-container', ['tarefas' => $this->tarefas]);
    }
}
