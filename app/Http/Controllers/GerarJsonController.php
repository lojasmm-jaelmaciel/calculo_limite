<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
// use Nette\Utils\Json as UtilsJson;
// use PHPUnit\Util\Json;
// use Psy\Util\Json as UtilJson;


class GerarJsonController extends Controller {
    /**
     * Busca todos os dados do DB e retorna no formato json.
     * Essa função é invocada pelo javascript csv_download.js. Este script irá transformar este
     * jswon em um csv para download.
     *
     * @return \Illuminate\Http\Response|Json
     */
    public function index()     {
        
        $resultado = DB::table('dados_pessoas')
        ->join('enderecos', 'dados_pessoas.endereco_id', '=', 'enderecos.id')
        ->leftJoin('dados_empresas', 'dados_pessoas.id', '=', 'dados_empresas.dados_pessoas_id')
        ->leftJoin('assinatura_consentimentos', 'dados_pessoas.id', '=', 'assinatura_consentimentos.dados_pessoas_id')
        ->get();

        header('Content-Type: application/json');
        return response($resultado);

    }
}