<?php

namespace App\Http\Controllers;

use App\Models\DadosPessoa;
use App\Models\Endereco;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ListaCadastrosController extends Controller {
    
    public function index(): View {
        $dados_db = DB::table('enderecos')
        ->join('dados_pessoas', 'enderecos.id', '=', 'dados_pessoas.endereco_id')
        ->get();
        
        $dados = [
            'dados' => $dados_db,       
        ];
        
        return view('lista_cadastros', $dados);        

    }

    public function detalheCadastro(int $id): View {

        $usuario = DadosPessoa::find($id);
        $dados = [
            'usuario' => $usuario
        ];

        return view('detalhe_cadastro', $dados);

    }


} // class ListaCadastros