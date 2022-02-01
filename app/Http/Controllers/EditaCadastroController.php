<?php

namespace App\Http\Controllers;

use App\Models\DadosPessoa;
use App\Models\DadosEmpresa;
use App\Models\Endereco;
use Exception;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EditaCadastroController extends Controller {
    
    /* A função index() é invocada quando uma requisição do tipo GET é feita. A função busca os dados no DB
    formata alguns atributos para o padrão brasileiro e envia para a view.  
    OBS: A variável $mensagem se faz necessário, pois a view verifica por sua existêcia, já que ao editar algum
    dado uma mensagem de erro ou de sucesso é exibita */


    public function index(int $id, array $mensagem = null): View {
        
        $estados = estados();

        // busca os dados no DB através do ID dos dados pessoais
        $dados_pessoas = DadosPessoa::find($id);
        $endereco_id = $dados_pessoas->endereco_id;
        $endereco = Endereco::find($endereco_id);
        $profissional = DadosEmpresa::where('dados_pessoas_id', $id)->get();
        $dados_profissionais = $profissional[0];

        // formata os dados para o padrão pt-br
        $dados_pessoas->data_nascimento = formataDataPtBr($dados_pessoas->data_nascimento);
        $dados_pessoas->rg_data_expedicao = formataDataPtBr($dados_pessoas->rg_data_expedicao);
        $endereco->reside_desde = formataDataPtBr($endereco->reside_desde);
        $dados_profissionais->salario = number_format($dados_profissionais->salario, 2, ',', '.');
        $dados_profissionais->data_admissao = formataDataPtBr($dados_profissionais->data_admissao);
        $mensagem = null;
                
        $dados = [
            'dados_pessoas' => $dados_pessoas,
            'endereco' => $endereco,
            'dados_profissionais' => $dados_profissionais,
            'estados' => $estados,
            'mensagem' => $mensagem
        ];
        return view('edita_cadastro', $dados);
    }

    /* A função editaCadastro() é invocada quando uma requisição do tipo PUT é feita. A função busca os dados no DB
    valida as informações, depois extrai os values do formulário, faz o update formata alguns atributos para o padrão 
    brasileiro e envia para a view e retorna com os novos dados
    Se o update não é possível, os dados antigos é retornado e uma mensagem com o erro é exibida  */


    public function editaCadastro(int $id, Request $request): View {

        $estados = estados();

        // busca os dados no DB através do ID dos dados pessoais
        $dados_pessoas = DadosPessoa::find($id);
        $endereco_id = $dados_pessoas->endereco_id;
        $endereco = Endereco::find($endereco_id);
        $profissional = DadosEmpresa::where('dados_pessoas_id', $id)->get();
        $dados_profissionais = $profissional[0];

        $foto_nome = $dados_pessoas->foto;
        
        validaDadosFormulario($request);      
        $dados_extraidos = extraiDadosFormulario($request, $foto_nome);

        // tenta fazer o update, se der errado, abre uma exceção
        try {
            
            $dados_extraidos['dados_pessoas'];
            $dados_pessoas->update($dados_extraidos['dados_pessoas']);
            $endereco->update($dados_extraidos['dados_endereco']);
            $dados_profissionais->update($dados_extraidos['dados_profissionais']);

            $dados_pessoas = DadosPessoa::find($id);
            $endereco_id = $dados_pessoas->endereco_id;
            $endereco = Endereco::find($endereco_id);
            $profissional = DadosEmpresa::where('dados_pessoas_id', $id)->get();
            $dados_profissionais = $profissional[0];

            $mensagem = ["classe" => "mensagem-sucesso", "mensagem" => "Dados alterados"];


        } catch (Exception $e) {
            $mensagem = ["classe" => "mensagem-erro", "mensagem" => "Erro ao salvar os dados: " . $e->getMessage()];
            
        }

        // formata os dados para o padrão pt-br
        $dados_pessoas->data_nascimento = formataDataPtBr($dados_pessoas->data_nascimento);
        $dados_pessoas->rg_data_expedicao = formataDataPtBr($dados_pessoas->rg_data_expedicao);
        $endereco->reside_desde = formataDataPtBr($endereco->reside_desde);
        $dados_profissionais->salario = str_replace(".", "", $dados_profissionais->salario);
        $dados_profissionais->data_admissao = formataDataPtBr($dados_profissionais->data_admissao);

        $dados = [
            'dados_pessoas' => $dados_pessoas,
            'endereco' => $endereco,
            'dados_profissionais' => $dados_profissionais,
            'estados' => $estados,
            'mensagem' => $mensagem
        ];

        return view('edita_cadastro', $dados);
        // return redirect()->action( [EditaCadastroController::class, 'index'], ['id' => $id]);
    }
}