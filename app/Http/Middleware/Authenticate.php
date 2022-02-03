<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Sempre que o usuário tentar acessar algo que tem a necessidade de estar logado
     * é direcionado para o formulário de autenticação.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('autenticacao.form');
        }
    }
}
