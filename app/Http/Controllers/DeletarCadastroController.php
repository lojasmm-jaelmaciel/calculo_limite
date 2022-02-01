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

    public function index(int $id): View {

        $dados_pessoas = DadosPessoa::find($id);
        $dados = [
            'dados' => $dados_pessoas
        ];

        return View('deletar_cadastro', $dados);
    }




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
            dd($dados_pessoas);
        }
        
        return redirect('/lista-cadastros');
    }
    
}