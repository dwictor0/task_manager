<?php

namespace App\Livewire;

use App\Services\TarefasService;
use Livewire\Component;

class DeputadoIndex extends Component
{
    public $deputado;
    public $totalTarefasDeputado;
    
    /**
     * Summary of mount
     * @param \App\Services\TarefasService $service
     * @return void
     */
    public function mount(TarefasService $service)
    {
      $this->deputado = $service->deputadosComTarefa();
    }
    
    /**
     * Summary of render
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.deputado-index',['deputado' => $this->deputado]);
    }
}
