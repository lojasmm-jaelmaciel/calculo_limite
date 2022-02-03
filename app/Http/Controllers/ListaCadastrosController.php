<?php

namespace App\Http\Controllers;

use App\Models\DadosPessoa;
use App\Models\Endereco;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ListaCadastrosController extends Controller {

    /**
     * Esta função busca os dados pessoais e de endereço para mostrar o mínimo de dados que identifique
     * o cadastro na view. Depois retorna para a view lista_cadastros onde estará disponível os botãos
     * para editar e ou deletar um cadastro
     *
     * @return View
     */
    public function index(): View {
        $dados_db = DB::table('enderecos')
        ->join('dados_pessoas', 'enderecos.id', '=', 'dados_pessoas.endereco_id')
        ->get();
        
        $dados = [
            'dados' => $dados_db,       
        ];
        
        return view('lista_cadastros', $dados);        

    }

} // class ListaCadastros