<?php

namespace App\Http\Controllers;

use App\Models\AssinaturaConsentimento;
use App\Models\DadosPessoa;
use App\Models\DadosEmpresa;
use App\Models\Endereco;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class DeletarCadastroController extends Controller {

    /**
     * Função recebe um pedido para deleção de cadastro e retorna uma view
     * exibindo os dados em questão para que o usuário confirme sua deleção
     *
     * @param integer $id
     * @return View
     */
    public function index(int $id): View {

        $dados_pessoas = DadosPessoa::find($id);
        $dados = [
            'dados' => $dados_pessoas
        ];

        return View('deletar_cadastro', $dados);
    }


    
    /**
     * Caso a deleção seja confirmada, então é feito uma busca nas tabelas que compõe
     * os dados do registro a ser deletado. Antes de deletar os dados da tabela dados_pessoas
     * o nome do arquivo da foto é resgatado para então por último ser deletado. Caso algum problema
     * ocorra dentro do try, o catch envia uma mensagem para a view e por fim
     * a página é redirecionada para a lista de cadastros.
     *
     * @param integer $id
     * @return redirect
     */
    public function deletarCadastro(int $id) {

        $dados_pessoas = DadosPessoa::find($id);
        $endereco = Endereco::find($dados_pessoas->endereco_id);
        $dados_profissionais = DadosEmpresa::where('dados_pessoas_id', $id)->get();
        $dados_localizacao = AssinaturaConsentimento::where('dados_pessoas_id', $id)->get();
        
        
        try {
            if (!empty($dados_localizacao[0])) $dados_localizacao[0]->delete();
            if (!empty($dados_profissionais[0])) $dados_profissionais[0]->delete();
            if (!empty($dados_pessoas)){
                $foto = $dados_pessoas->foto;
                $dados_pessoas->delete();
            } 
            if (!empty($endereco)) $endereco->delete();
            if (!empty($foto)) File::delete(public_path('img/foto/').$foto);


        } catch(Exception $e){
            echo $e->getMessage();
        }
        
        return redirect('/lista-cadastros');
    }
    
}