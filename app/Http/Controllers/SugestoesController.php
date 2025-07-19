<?php

namespace App\Http\Controllers;

use App\Models\Sugestao;
use Auth;
use Illuminate\Http\Request;

class SugestoesController extends Controller
{
    private $sugestao;

    /**
     * Summary of __construct
     * @param \App\Models\Sugestao $sugestao
     */
    public function __construct(Sugestao $sugestao)
    {
        $this->sugestao = $sugestao;
    }

    /**
     * Summary of indexSugestoes
     * @return \Illuminate\Contracts\View\View
     */
    public function indexSugestoes()
    {
        $sugestoesAtivas = $this->sugestao->where('id','>=','1')->get();
        return view('sugestao.indexSugestao',@compact('sugestoesAtivas',$sugestoesAtivas));
    }

    /**
     * Summary of criarSugestoes
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function criarSugestoes(Request $request)
    {
        return view('sugestao.createSugestao');
    }

    /**
     * Summary of salvarSugestoes
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\RedirectResponse
     */
    public function salvarSugestoes(Request $request)
    {
        $userId = Auth::id();

        $this->sugestao->create([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'usuario_id' => $userId,
        ]);

        return redirect()->route('sugestao.index');

    }

    public function atualizarSugestao(Request $request)
    {
      dd($request->all());
    }
}
