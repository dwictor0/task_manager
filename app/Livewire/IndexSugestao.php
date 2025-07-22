<?php

namespace App\Livewire;

use App\Models\Sugestao;
use App\Services\SugestaoService;
use Livewire\Component;

class IndexSugestao extends Component
{
    public $sugestao;

    /**
     * Summary of mount
     * @param \App\Services\SugestaoService $sugestaoService
     * @return void
     */
    public function mount(SugestaoService $sugestaoService)
    {
      $this->sugestao = $sugestaoService->verificaSugestoesAtivas();
    }

    /**
     * Summary of render
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.index-sugestao',['sugestoesAtivas' => $this->sugestao]);
    }

}
