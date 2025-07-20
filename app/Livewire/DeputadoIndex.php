<?php

namespace App\Livewire;

use App\Services\TarefasService;
use Livewire\Component;

class DeputadoIndex extends Component
{
    public $deputado;
    public $totalTarefasDeputado;
    public function mount(TarefasService $service)
    {
      $this->deputado = $service->deputadosComTarefa();
    }
    public function render()
    {
        return view('livewire.deputado-index',['deputado' => $this->deputado]);
    }
}
