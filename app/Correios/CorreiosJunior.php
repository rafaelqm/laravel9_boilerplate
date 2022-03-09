<?php


namespace App\Correios;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class CorreiosJunior implements CorreiosInterface
{
    public function buscaCep($cep)
    {
        $uri =
            'https://brasilapi.com.br/api/cep/v1/' . $cep;

        $dados = [];
        try {
            $client = new Client();
            $response = $client->get($uri);
            $dados = json_decode($response->getBody()->getContents());

            $dados->cidade = $dados->city;
            $dados->logradouro = $dados->street;
            $dados->bairro = $dados->neighborhood;

            unset($dados->city);
            unset($dados->street);
            unset($dados->neighborhood);

        } catch (\Exception $e) {
            if ($e->getCode() != 404) {
                Log::error($e);
                Bugsnag::notifyException($e);
            }
        }

        return json_encode($dados);
    }
}
