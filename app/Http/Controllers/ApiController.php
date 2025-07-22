<?php
namespace App\Http\Controllers;
use App\Models\Deputados;
use DB;
use Exception;
use Illuminate\Support\Facades\Http;
use Log;


class ApiController extends Controller
{
    /**
     * Summary of deputados
     * @var 
     */
    private $deputados;

    /**
     * Summary of __construct
     * @param \App\Models\Deputados $deputados
     */
    public function __construct(Deputados $deputados)
    {
        $this->deputados = $deputados;
    }

    /**
     * Summary of renderizaApi
     * @return void
     */
    public function renderizaApi()
    {
        try {
            if ($this->deputados->count() == 0) {

                $url = 'https://dadosabertos.camara.leg.br/api/v2/deputados';

                $response = Http::get($url);

                if (!$response->successful()) {
                    Log::error("Erro ao acessar a API dos deputados com a URL fornecida");
                }

                DB::beginTransaction();
                
                $dados = $response->json();
                $deputados = $dados['dados'] ?? [];

                foreach ($deputados as $dep) {
                    $this->deputados->create(
                        [
                            'nome' => $dep['nome'],
                            'partido' => $dep['siglaPartido'],
                            'imagem_deputado' => $dep['urlFoto'],
                            'uf' => $dep['siglaUf'],
                        ],
                    );
                }
                DB::commit();
            }
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Erro ao renderizar a API:{$e->getMessage()} | Linha: {$e->getLine()} | Trace: {$e->getTraceAsString()}");
        }
    }
}
