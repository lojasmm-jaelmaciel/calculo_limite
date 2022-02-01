<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Nette\Utils\Json as UtilsJson;
use PHPUnit\Util\Json;
use Psy\Util\Json as UtilJson;

class GerarJsonController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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