<?php

namespace App;

use App\Http\Requests\AtualizaTarefasRequest;
use App\Http\Requests\CriacaoDeTarefasRequest;
use App\Models\ListaTarefas;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

interface ListaDeTarefasInterface
{
    public function index(): View;
    public function create(): View;
    public function store(CriacaoDeTarefasRequest $request): View|RedirectResponse;
    public function edit(ListaTarefas $tarefa): View;
    public function update(AtualizaTarefasRequest $request, ListaTarefas $tarefa): View|RedirectResponse;
    public function indexSoftDelete(): View;
    public function destroy(int $id): View|RedirectResponse;
    public function restore(int $id): View|RedirectResponse;
    public function controleTarefas(): View;
}
