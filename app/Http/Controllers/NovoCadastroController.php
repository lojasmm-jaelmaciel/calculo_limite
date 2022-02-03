<?php

/*######## Padrão do envio de mensagens do tipo modal! ########*/
/* Existe uma sessão @section('mensagem') onde a mensagem é exibida. As telas que tem a necessidade
de uma mensagem do tipo modal, ex: novos cadastros é obrigatório criar uma variável/array com o nome $mensagem. 
Se não tem mensagem a ser enviada a variável deve ser do tipo null $mensagem = null.
Se há necessidade de exibir uma mensagem, então deve ser criado um array com as chaves "classe" e "mensagem"
Chave "classe" deve ser "mensagem-sucesso" ou "mensagem-erro. Isso impacta nas cores da mensagem verde/vermelho".
Chave "mensagem" é a mensagem a ser exibida para o usuário! */
// $mensagem = ["classe" => "mensagem-erro", "mensagem" => "Dados salvos com sucesso"];        
// $mensagem = null;

namespace App\Http\Controllers;

use App\Models\AssinaturaConsentimento;
use App\Models\DadosPessoa;
use App\Models\DadosEmpresa;
use App\Models\Endereco;
use Exception;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NovoCadastroController extends Controller
{

    /**
     * * Função index exibe para o usuário um formulário vazio pronto para ser prenchido 
     * Envia um array com os estados da federação brasileira onde é usado no preenchimento do 
     * estado de naturalidade do usuário. A variavel $mensagem se faz necessário por na view
     * existe uma verificação da sua existência. Ela é usada para mostrar mensagens de erro
     * ou sucesso no cadatro.
     *
     * @return View
     */
    public function index(): View {
        // $ip = $_SERVER['REMOTE_ADDR'];

        // recebe a lista de estados da função estados em Helpers/estados.php
        $estados = estados();
      
        $mensagem = null;

        $dados = [
            'estados' => $estados,
            'mensagem' => $mensagem
        ];

        return view('cadastro', $dados);
    }





    
    /**
     * A função novoCadastro é acionada quando o usuário prescionar o botão salavar. Uma requisição POST é feita.
     * Uma função para validar os dados validaDadosFormulario() é chamada onde cada dado passa por determinadas regras.
     * Se os dados não forem consistentes, o sistema volta para o formulário com os respectivos avisos das inconsistências.
     * obs: o formulário fica com as informações que já havia sido digitadas pelo usuário.
     * Se a validação for ok, os dados são extraídos extraiDadosFormulario() nos seus respectivos arrays(referente as tabelas no DB)
     * e retorna um array de arrays que será enviados para serem persistidos no DB. A sequência ao qual os dados são gravados, se faz 
     * necessário devido a relação das tabelas através do ID. Para que o relacionamento seja possível entre as tabelas a coluna
     * de relacionamento + o ID é adicionado no array antes de persistir os dados no DB.
     * Se uma das tabelas der erro no INSERT, dentro do cath as tabelas que foram cadastradas são deletadas para que não tenhamos
     * dados soltos sem relação no DB.
     *
     * @param Request $request
     * @return View
     */
    public function novoCadastro(Request $request): View
    {
        // recebe a lista de estados da função estados em Helpers/estados.php
        $estados = estados();

        // essas função estão em Helpers
        validaDadosFormulario($request);
        $dados_extraidos = extraiDadosFormulario($request);
    
        try {
            $dados_endereco = null;
            $dados_pessoas = null;
            $dados_profissionais = null;
            $dados_localizacao = null;

            // os dados que foram extraidos do fomulário são agora persistidos no banco
            // as tabelas com relacionamento, é adicionado o campo + o ID ao qual é feita a relação
            $dados_endereco = Endereco::create($dados_extraidos['dados_endereco']);

            $dados_extraidos['dados_pessoas']['endereco_id'] = $dados_endereco->id;
            $dados_pessoas = DadosPessoa::create($dados_extraidos['dados_pessoas']);

            $dados_extraidos['dados_profissionais']['dados_pessoas_id'] = $dados_pessoas->id;
            $dados_profissionais = DadosEmpresa::create($dados_extraidos['dados_profissionais']);

            $dados_extraidos['dados_localizacao']['dados_pessoas_id'] = $dados_pessoas->id;
            $dados_localizacao = AssinaturaConsentimento::create($dados_extraidos['dados_localizacao']);
            

            // se tudo estiver OK, é retornado para o formulário com uma mensagem
            // se der errado, cai no exception, deleta os dados que tenham sido cadastrados e envia a mensagem com o erro.
            $mensagem = ["classe" => "mensagem-sucesso", "mensagem" => "Os dados foram salvos com sucesso"];

            $dados = [
                'estados' => $estados,
                'mensagem' => $mensagem
            ];

            return view('cadastro', $dados);
            
        } catch (Exception $e) {
            $mensagem = ["classe" => "mensagem-erro", "mensagem" => "Erro ao salvar os dados: " . $e->getMessage()];
            // Deleta os possíveis dados que tenham sido cadastrados para não ficarem dados soltos na base de dados.
            if ($dados_localizacao) AssinaturaConsentimento::destroy($dados_localizacao);
            if ($dados_profissionais) DadosEmpresa::destroy($dados_profissionais->id);
            if ($dados_pessoas) DadosPessoa::destroy($dados_pessoas->id);
            if ($dados_endereco) Endereco::destroy($dados_endereco->id);

            $dados = [
                'estados' => $estados,
                'mensagem' => $mensagem
            ];

            return view('cadastro', $dados);
        }
    }

}