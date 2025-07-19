<?php
namespace App\Http\Controllers;
use App\Models\Deputados;
use Illuminate\Support\Facades\Http;


class ApiController extends Controller
{
    public function renderizaApi()
    {
        $url = 'https://legis.senado.leg.br/dadosabertos/senador/lista/atual';

        $response = Http::get($url);
        $xmlString = $response->body();
        $xml = simplexml_load_string($xmlString);
        $json = json_encode($xml);
        $array = json_decode($json, true);
        $collect = collect($array);
        $parlamentares = data_get($collect, 'Parlamentares.Parlamentar');

        if (isset($parlamentares['IdentificacaoParlamentar'])) {
            $parlamentares = [$parlamentares];
        }
        collect($parlamentares)->each(function ($parlamentar) {
            $identificacao = $parlamentar['IdentificacaoParlamentar'] ?? [];

            Deputados::create(
                [
                    'nome' => $identificacao['NomeParlamentar'] ?? null,
                    'id_api' => $identificacao['CodigoParlamentar'] ?? null,
                    'partido' => $identificacao['SiglaPartidoParlamentar'],
                    'imagem_senador' => $identificacao['UrlFotoParlamentar']
                ]
            );
        });

    }
}
