@extends('template')

@section('titulo', 'Deletar Cadastro')

@section('conteudo')

    <form method="post">
        @csrf
        @method('DELETE')

        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 delete-titulo">

                </div>
            </div>
            <div class="row">
                <div class="col-md-4 delete-imagem">
                    <img class="exibe-img" src="/img/foto/{{ $dados->foto }}">
                </div>

                <div class="col-md-6 offset-1">
                    <div class="row">
                        <div class="col-md-12 delete-dados">
                            <strong>Nome: </strong> {{ $dados->nome }}
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 delete-dados">
                            <strong>CPF: </strong><span class="cpf-mask"> {{ $dados->cpf }}</span>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 delete-dados">
                            <strong>Celular: </strong><span class="cel-mask"> {{ $dados->telefone }}</span>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12 delete-confirmacao">
                    Você realmente deseja deletar este cadastro? &nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="submit" class="btn btn-success btn-lg">Sim</button>
                    <a href="{{ route('cadastro.listar') }}" class="btn btn-danger btn-lg">Não</a>
                </div>
            </div>
        </div>
    </form>
@endsection
