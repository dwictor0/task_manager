<?php

namespace App\Livewire;

use App\Services\TarefasService;
use Livewire\Component;

class SenadorIndex extends Component
{
    public $senador;
    public function mount(TarefasService $service)
    {
      $this->senador = $service->allSenadores();
    }
    public function render()
    {
        return view('livewire.senador-index',['senador' => $this->senador]);
    }
}
