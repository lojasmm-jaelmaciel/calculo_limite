<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Hash;


class AutenticacaoController extends Controller{

    /**
     * direciona para a view autenticar quando acessado website/login ou qualquer link
     * que necessite estar logado
     *
     * @return view
     */ 
    function index(): View {
        return view('autenticar');
    }



    /**
     * função faz a autenticação caso as credenciais que o usuário digitou confere com os dados do DB. 
     * Ao receber a request é feito um teste para ver se os dados são válidos. Se a autenticação ocorrer tudo bem 
     * então retorna para a página home. 
     * Este é o Hash usado para cirar a senha que foi cadastrada no DB ( Hash::make($request->passoword);)
     *
     * @param Request $request
     * @return redirect
     */
    function autenticacao(Request $request){
        
       $dados = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (Auth::attempt($dados)){
        //    return redirect()->intended('cadastro.home');
            return redirect()->route('cadastro.home');

        }
        return back()->withErrors([
            'email' => 'Email e/ou senha inválidos'
        ]);
    }

    /**
     * Recebe um requisição do tipo GET e faz o logout no sistema.
     * Invalida a sessão e o token. O token neste caso não foi implementado.
     * O token serve para permite o usuário ficar logado sempre. O token só fica inválido
     * quando manualmente o usuário fazer o logout. 
     * 
     * @param Request $request
     * @return redirect
     */
    public function sair(Request $request){
        
        Auth::logout();
        $request->session()->invalidate();
        // $request->session()->regenerateToken();

        return redirect('/');

    }
    
}