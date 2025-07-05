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

    /**
     * Summary of mount
     * @param \App\Services\TarefasService $tarefas
     * @return void
     */
    public function mount(TarefasService $tarefas)
    {
        $this->tarefasService = $tarefas;
        $this->atualizarTarefas();
    }

    /**
     * Summary of atualizarTarefas
     * @return void
     */
    public function atualizarTarefas()
    {
        $this->tarefas = app(\App\Services\TarefasService::class)->indexTarefas();
    }

    /**
     * Summary of render
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.dashboard-container', ['tarefas' => $this->tarefas]);
    }
}
