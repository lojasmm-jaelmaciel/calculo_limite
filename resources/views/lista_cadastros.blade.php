@extends('template')

@section('titulo', 'Lista de Cadastros')

@section('conteudo')

<div class="container">

    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nome</th>
                <th scope="col">Telefone</th>
                <th scope="col">Cidade</th>
                <th scope="col">Estado</th>
                <th scope="col" colspan="2" style="text-align:center">Ação</th>
            </tr>
        </thead>
        </tbody>
        @foreach ($dados as $dado)
            <tr>
                <td>{{ $dado->id }}</td>
                <td>{{ $dado->nome }}</td>
                <td>{{ $dado->telefone }}</td>
                <td>{{ $dado->cidade }}</td>
                <td>{{ $dado->estado }}</td>
                <td style="text-align:center">
                    <a class="btn btn-info" href="{{ route('cadastro.editar', $dado->id) }}">Editar</a>
                </td>
                <td style="text-align:center">
                    <a class="btn btn-danger" href="{{ route('cadastro.deletar', $dado->id) }}">Apagar</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <a class="btn btn-success" href="" onclick="gerarCSV()">Download CSV</a>
    {{-- <a class="btn btn-success" href="{{ route('cadastro.json') }}" onclick="gerarCSV()">Gerar Json</a> --}}
</div>
@endsection
