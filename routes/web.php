<?php

use App\Http\Controllers\AutenticacaoController;
use App\Http\Controllers\BuscarCadastroController;
use App\Http\Controllers\EditaCadastroController;
use App\Http\Controllers\ListaCadastrosController;
use App\Http\Controllers\NovoCadastroController;
use App\Http\Controllers\DeletarCadastroController;
use App\Http\Controllers\GerarJsonController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//Rotas protegidas por autenticação.
Route::group(['middleware' => 'auth'], function(){
    Route::get('/lista-cadastros', [ListaCadastrosController::class, 'index'])->name('cadastro.listar');
    Route::get('/delete-cadastro/{id}', [DeletarCadastroController::class, 'index'])->name('cadastro.deletar');
    Route::delete('/delete-cadastro/{id}', [DeletarCadastroController::class, 'deletarCadastro'])->name('cadastro.deletar');
    Route::get('/json', [GerarJsonController::class, 'index'])->name('cadastro.json');
    Route::get('/logout', [AutenticacaoController::class, 'sair'])->name('autenticacao.sair');
});

// Rotas públicas
Route::get('/', [NovoCadastroController::class, 'index'])->name('cadastro.home');
Route::post('/', [BuscarCadastroController::class, 'index'])->name('cadastro.buscar');
Route::get('/cadastro', [NovoCadastroController::class, 'index']);
Route::post('/cadastro', [NovoCadastroController::class, 'novoCadastro'])->name('cadastro.novo-cadastro');
Route::get('/detalhe-cadastro/{id}', [ListaCadastrosController::class, 'detalheCadastro'])->name('cadastro.detalhe');
Route::get('/edita-cadastro/{id}',[EditaCadastroController::class, 'index'])->name('cadastro.editar');
Route::put('/edita-cadastro/{id}', [EditaCadastroController::class, 'editaCadastro'])->name('cadastro.editar');
// a rota autenticacao.form é o destino quando o usuário não estiver logado e quiser acessar rotas que estão no middleware => auth
// este redirecionamento é feito dentro de app/Http/Middleware/Authenticate.php
Route::get('/login', [AutenticacaoController::class, 'index'])->name('autenticacao.form');
Route::post('/login', [AutenticacaoController::class, 'autenticacao'])->name('autenticacao.autenticar');

