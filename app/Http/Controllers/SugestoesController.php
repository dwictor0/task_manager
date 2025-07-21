<?php

namespace App\Http\Controllers;

use App\Http\Requests\AtualizarSugestaoRequest;
use App\Http\Requests\SugestaoRequest;
use App\Models\Sugestao;
use App\Models\SugestaoVotos;
use App\Services\SugestaoService;
use App\SugestoesInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Exception;
use Illuminate\Http\Request;
use Log;

class SugestoesController extends Controller implements SugestoesInterface
{
    /**
     * Summary of sugestao
     * @var 
     */
    private $sugestao;

    /**
     * Summary of sugestaoVotos
     * @var 
     */
    private $sugestaoVotos;

    /**
     * Summary of sugestaoService
     * @var 
     */
    private $sugestaoService;

    /**
     * Summary of __construct
     * @param \App\Models\Sugestao $sugestao
     */
    public function __construct(Sugestao $sugestao, SugestaoVotos $sugestaoVotos, SugestaoService $sugestaoService)
    {
        $this->sugestao = $sugestao;
        $this->sugestaoVotos = $sugestaoVotos;
        $this->sugestaoService = $sugestaoService;
    }

    /**
     * Summary of indexSugestoes
     * @return \Illuminate\Contracts\View\View
     */
    public function indexSugestoes(): View
    {
        try {
            $sugestoesAtivas = $this->sugestaoService->verificaSugestoesAtivas();

            return view('sugestao.indexSugestao', @compact('sugestoesAtivas', $sugestoesAtivas));
        } catch (Exception $e) {
            Log::error("Erro ao carregar sugestões:{$e->getMessage()} | Linha: {$e->getLine()} | Trace {$e->getTraceAsString()}");
            return view('errors.exception');
        }
    }

    /**
     * Summary of criarSugestoes
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function criarSugestoes(Request $request): View
    {
        return view('sugestao.createSugestao');
    }

    /**
     * Summary of salvarSugestoes
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function salvarSugestoes(SugestaoRequest $request): RedirectResponse|View
    {
        try {
            $this->sugestaoService->criandoSugestoes($request);

            return redirect()->route('sugestao.index')->with('success', 'Sugestão enviada com sucesso.');
        } catch (Exception $e) {
            Log::error("Erro ao criar sugestões:{$e->getMessage()} | Linha: {$e->getLine()} | Trace {$e->getTraceAsString()}");
            return view('errors.exception');
        }

    }

    /**
     * Summary of atualizarSugestao
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function atualizarSugestao(AtualizarSugestaoRequest $request): RedirectResponse|View
    {
        try {
            $this->sugestaoService->editandoSugestoes($request);
    
            return redirect()->back()->with('success','Voto enviado!');
        } catch (Exception $e) {
            Log::error("Erro ao atualizar sugestões:{$e->getMessage()} | Linha: {$e->getLine()} | Trace {$e->getTraceAsString()}");
            return view('errors.exception');
        }

    }
}
