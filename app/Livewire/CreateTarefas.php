<?php

namespace App\Livewire;

use App\Http\Requests\CriacaoDeTarefasRequest;
use App\Services\TarefasService;
use Livewire\Component;
use Validator;

class CreateTarefas extends Component
{
    
    public function save(TarefasService $service)
    {
        $validated = Validator::make( $this->all(), (new CriacaoDeTarefasRequest())->rules())->validate();
        $service->criarTarefas($validated);
    }
    
    public function render()
    {
        return view('livewire.create-tarefas');
    }
}
