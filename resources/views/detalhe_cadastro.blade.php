@extends('template')

@section('titulo', 'Detalhe do Cadastro')

@section('conteudo')

    {{ $usuario->id }} <br/>
    {{ $usuario->nome }}

@endsection
