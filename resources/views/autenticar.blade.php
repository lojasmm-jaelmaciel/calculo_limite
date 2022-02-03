@extends('template')

@section('titulo', 'Login')

@section('conteudo')
<div class="container">
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <div class="login-form bg-light mt-4 p-4">
                <form method="POST" class="row g-3">
                    @csrf
                    <div class="col-12">
                        <input type="text" name="email" class="form-control" placeholder="E-mail">
                    </div>
                    <div class="col-12">
                        <input type="password" name="password" class="form-control" placeholder="Senha">
                    </div>
                    {{-- <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="rememberMe">
                            <label class="form-check-label" for="rememberMe">&nbsp; Lembrar senha</label>
                        </div>
                    </div> --}}
                    <div class="col-12">
                        <button type="submit" class="btn btn-outline-danger float-end">Login</button>
                    </div>
                </form>
                <hr class="mt-4">
            </div>
        </div>
    </div>
</div>

@endsection