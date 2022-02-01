<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="{{ url('css/style.css') }}" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>@yield('titulo')</title>
</head>

<body>

    <div class="container">

        <nav class="navbar navbar-expand-lg navbar-light bg-red">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('cadastro.home') }}">
                    <img class="logo" src="/img/logo_mm.png">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('cadastro.home') }}" style="color: #ffffff">Home</a>
                        </li>
                        
                        @if (auth()->check())   
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('cadastro.listar') }}" style="color: #ffffff">Listar Cadastros</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="" onclick="gerarCSV()" style="color: #ffffff">Dowload Cadstros</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="{{ route('autenticacao.sair') }}" style="color: #ffffff">Logout</a>
                            </li>
                        @else        
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="{{ route('autenticacao.form') }}" style="color: #ffffff">Login</a>
                            </li>
                        @endif
                    </ul>
                    <form class="d-flex" action="{{ route('cadastro.buscar') }}" method="post">
                        @csrf
                        <input class="form-control me-2" type="text" name="buscar" placeholder="Buscar pelo CPF ou E-MAIL">
                        <button class="btn btn-outline-light" type="submit">Pesquisar</button>
                    </form>
                </div>
            </div>
        </nav>

        @yield('mensagem')

        @yield('conteudo')

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="{{ url('js/jquery.js') }}"></script>
    <script src="{{ url('js/script.js') }}"></script>
    <script src="{{ url('js/mask.js') }}"></script>
    <script src="{{ url('js/cep.js') }}"></script>
    <script src="{{ url('js/csv_download.js') }}"></script>

</body>

</html>
