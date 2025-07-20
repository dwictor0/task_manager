<?php

namespace App\Livewire;

use App\Models\Sugestao;
use App\Services\SugestaoService;
use Livewire\Component;

class IndexSugestao extends Component
{
    public $sugestao;

    public function mount(SugestaoService $sugestaoService)
    {
      $this->sugestao = $sugestaoService->verificaSugestoesAtivas();
    }
    public function render()
    {
        return view('livewire.index-sugestao',['sugestoesAtivas' => $this->sugestao]);
    }

}
