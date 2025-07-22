<?php

namespace App;
use App\Http\Requests\AtualizarSugestaoRequest;
use App\Http\Requests\SugestaoRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

interface SugestoesInterface
{
    /**
     * Exibe a lista de sugestões
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function indexSugestoes(): View;

    /**
     * Exibe o formulário para criação de uma nova sugestão
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function criarSugestoes(Request $request): View;

    /**
     * Armazena uma nova sugestão
     *
     * @param \App\Http\Requests\SugestaoRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Contracts\View\View
     */
    public function salvarSugestoes(SugestaoRequest $request): RedirectResponse|View;

    /**
     * Atualiza uma sugestão existente
     *
     * @param \App\Http\Requests\AtualizarSugestaoRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Contracts\View\View
     */
    public function atualizarSugestao(AtualizarSugestaoRequest $request): RedirectResponse|View;

}
