<?php

namespace App\Http\Controllers;

use App\Models\DadosPessoa;
use Exception;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class BuscarCadastroController extends Controller{
    

    /**
     * Função usada para fazer uma buica no DB através do e-mail ou do CPF.
     * O algoritmo identifica se tem um arroba na string, caso positivo, a busca é feita pelo e-mail
     * caso negativo, a busca é feita pelo CPF. Antes de buscar pelo CPF, todos os caracteres que 
     * não sejam números são eliminados da string. Conforme o resultado da busca, a variável $redirecionamento
     * receberá uma string com o nome a view de destino.
     * Se o cadastro não for encontrado, uma mensagem de erro é gerada no (Exception) e exibida na tela.
     * 
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View {

        $buscar = $request->buscar;
        try {

            if (strpos($buscar, '@')){
                $dados_pessoas = DadosPessoa::where('email', $buscar)->get();
            } else {
                $buscar = somenteNumeros($buscar);
                $dados_pessoas = DadosPessoa::where('cpf', $buscar)->get();
            }
            
            $dados_db = DB::table('enderecos')
            ->join('dados_pessoas', 'enderecos.id', '=', 'dados_pessoas.endereco_id')
            ->where('dados_pessoas.id', $dados_pessoas[0]->id)
            ->get();

            $redirecionamento = 'lista_cadastros';
            $dados = [
                'dados' => $dados_db
            ];

        } catch(Exception $e){
            $redirecionamento = 'cadastro';
            $mensagem = ["classe" => "mensagem-erro", "mensagem" => "Nenhum registro foi encontrado com estes dados: " . $e->getMessage()];
            $dados_db = [];
            $estados = estados();
            $dados = [
                'estados' => $estados,
                'mensagem' => $mensagem
            ];
        }
        
        return view($redirecionamento, $dados);

    }

}