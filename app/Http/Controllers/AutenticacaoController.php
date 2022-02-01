<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


/*
Esta classe tem a função de direcionar para a tela de login, fazer a autenticação baseada em
usuário(email) e senha e fazer o logout.
*/

class AutenticacaoController extends Controller{

    // direciona para a view autenticar quando acessado website/login
    function index(){
        return view('autenticar');
    }



    /* função faz a autenticação caso as credenciais que o usuário digitou confere com os dados do DB.
    Ao receber a request é feito um teste para ver se os dados são válidos. Se a autenticação ocorrer tudo bem
    então retorna para a página home.*/
    //$x = Hash::make($request->passoword);
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


    /* Recebe um requisição do tipo GET e faz o logout no sistema invalidando a sessão e 
    não é o caso, regerando o token que serve de permite o usuário ficar logado sempre.
    Não está sendo implementando por isso está comentado */
    public function sair(Request $request){
        
        Auth::logout();
        $request->session()->invalidate();
        // $request->session()->regenerateToken();

        return redirect('/');

    }
    
}