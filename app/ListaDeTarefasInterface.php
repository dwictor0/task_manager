<?php

namespace App;

use App\Http\Requests\AtualizaTarefasRequest;
use App\Http\Requests\CriacaoDeTarefasRequest;
use App\Models\ListaTarefas;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

interface ListaDeTarefasInterface
{
    /**
     *  Exibe a lista de tarefas
     * @return void
     */
    public function index(): View;
    
    /**
     *  Exibe formulário para criação de tarefa
     * @return void
     */
    public function create(): View;

    /**
     * Armazena uma nova tarefa 
     * @param \App\Http\Requests\CriacaoDeTarefasRequest $request
     * @return void
     */
    public function store(CriacaoDeTarefasRequest $request): View|RedirectResponse;

    /**
     * Exibe formulário para edição de tarefa
     * @param \App\Models\ListaTarefas $tarefa
     * @return void
     */
    public function edit(ListaTarefas $tarefa): View;

    /**
     * Atualiza uma tarefa existente
     * @param \App\Http\Requests\AtualizaTarefasRequest $request
     * @param \App\Models\ListaTarefas $tarefa
     * @return void
     */
    public function update(AtualizaTarefasRequest $request, ListaTarefas $tarefa): View|RedirectResponse;

    /**
     * Exibe lista de tarefas deletadas (soft delete)
     * @return void
     */
    public function indexSoftDelete(): View;

    /**
     * Deleta uma tarefa
     * @param int $id
     * @return void
     */
    public function destroy(int $id): View|RedirectResponse;

    /**
     * Restaura uma tarefa deletada
     * @param int $id
     * @return void
     */
    public function restore(int $id): View|RedirectResponse;

    /**
     * Controle geral das tarefas
     * @return void
     */
    public function controleTarefas(): View;
}
