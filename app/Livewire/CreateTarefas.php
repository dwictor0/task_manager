<?php

namespace App\Livewire;

use App\Http\Requests\CriacaoDeTarefasRequest;
use App\Services\TarefasService;
use Livewire\Component;
use Validator;

class CreateTarefas extends Component
{
    public $senadores;

    /**
     * Summary of save
     * @param \App\Services\TarefasService $service
     * @return void
     */
    public function save(TarefasService $service)
    {
        $validated = Validator::make( $this->all(), (new CriacaoDeTarefasRequest())->rules())->validate();
        $service->criarTarefas($validated);
    }
    
    /**
     * Summary of render
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.create-tarefas',['senadores' => $this->senadores]);
    }
    
    public function mount(TarefasService $tarefasService)
    {
      $this->senadores = $tarefasService->allSenadores();
    }
}
