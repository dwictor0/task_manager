<?php

namespace App\Services;

use App\Models\Sugestao;
use App\Models\SugestaoVotos;

class SugestaoService
{
    private $sugestao;
    private $sugestaoVotos;
    /**
     * Create a new class instance.
     */
    public function __construct(Sugestao $sugestao,SugestaoVotos $sugestaoVotos)
    {
        $this->sugestao = $sugestao;
        $this->sugestaoVotos = $sugestaoVotos;
    }

    /**
     * Summary of verificaSugestoesAtivas
     * @return \Illuminate\Database\Eloquent\Collection<int, Sugestao>
     */
    public function verificaSugestoesAtivas()
    {
        return $this->sugestao->where('id', '>=', '1')->get();
    }
}
