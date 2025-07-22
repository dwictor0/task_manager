<?php

namespace App\Services;

use App\Models\Sugestao;
use App\Models\SugestaoVotos;
use Auth;
use DB;
use Exception;
use Log;

class SugestaoService
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
     * Create a new class instance.
     */
    public function __construct(Sugestao $sugestao, SugestaoVotos $sugestaoVotos)
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

    /**
     * Summary of criandoSugestoes
     * @param mixed $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function criandoSugestoes($request)
    {
        try {
            DB::beginTransaction();
            $userId = Auth::id();

            $this->sugestao->create([
                'titulo' => $request->titulo,
                'descricao' => $request->descricao,
                'usuario_id' => $userId,
            ]);

            DB::commit();

            return redirect()->route('sugestao.index')->with('success', 'Sugestão enviada com sucesso.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Erro ao criar sugestoes {$e->getMessage()}");
            throw $e;
        }
    }

    /**
     * Summary of editandoSugestoes
     * @param mixed $request
     * @return void
     */
    public function editandoSugestoes($request)
    {
        try {
            DB::beginTransaction();

            $userId = Auth::id();

            $this->sugestaoVotos->create([
                'usuario_id' => $userId,
                'sugestao_id' => $request->input('sugestao_id'),
            ]);
    
            $this->sugestao->where('id', $request->input('sugestao_id'))->increment('total_votos');
            
            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Erro ao editar sugestao {$e->getMessage()}");
            throw $e;
        }
    }
}
