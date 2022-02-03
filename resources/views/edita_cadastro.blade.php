@extends('template')

@section('titulo', 'Edição de Cadastros')


{{-- #################################################
 Sessão onde uma janela modal é exibida conforme a mensagem retornada --}}
@section('mensagem')
@if($mensagem)
    <div class="mensagem-modal" id="mensagem-modal">
        <div class="mensagem {{ $mensagem['classe'] }}">
            <button class="mensagem-fechar" onclick="fecharModal()">X</button>
            <h4>{{ $mensagem['mensagem'] }}</h4>
        </div>
    </div>
@endif
@endsection


@section('conteudo')

{{-- #####################################################
    Este bloco de código mostra as mensagens na tela no momento do cadastro
     caso alguma informação esteja errada ou faltando --}}
@if($errors->all()) 
    <div class="alert alert-danger">
        @foreach($errors->all() as $error)
            - {{ $error }}<br/>
        @endforeach
    </div>
@endif


    <form action="{{ route('cadastro.editar', $dados_pessoas) }}" method="POST" class="formulario" id="formulario" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <h1 class="text-center">Editar Dados</h1>
    
    {{-- ############################## Barra de Progresso ############################## --}}
    <div class="barraprogresso">
        <div class="progress" id="progress"></div>

        <div class="progress-step progress-step-active" data-title="Pessoal"></div>
        <div class="progress-step" data-title="Endereço"></div>
        <div class="progress-step" data-title="Profissional"></div>
        <div class="progress-step" data-title="foto"></div>
    </div>

    
    
    {{-- ############################## Dados pessoais ############################## --}}
    <div class="form-step form-step-active">
        <div class="input-group">
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome" value="{{ $dados_pessoas->nome }}"/>
        </div>

        <div class="input-group">
            <label for="data_nascimento">Data de Nascimento</label>
            <input type="text" name="data_nascimento" id="data_nascimento" class="date-mask" value="{{ $dados_pessoas->data_nascimento }}"/>
        </div>

        <div class="input-group">
            <input type="radio" class="btn-check" value="m" name="sexo" id="option1" autocomplete="off" {{$dados_pessoas->sexo == "m" ? "checked" : ""}}>
            <label class="btn btn-outline-danger check-box-btn" for="option1">Masculino</label>

            <input type="radio" class="btn-check" value="f" name="sexo" id="option2" autocomplete="off" {{$dados_pessoas->sexo == "f" ? "checked" : ""}}>
            <label class="btn btn-outline-danger" for="option2">Feminino</label>
        </div>

        <div class="input-group">
            <label for="cpf">CPF</label>
            <input type="text" name="cpf" id="cpf" class="cpf-mask" value="{{ $dados_pessoas->cpf }}" />
        </div>

        <div class="input-group">
            <label for="rg">RG</label>
            <input type="text" name="rg" id="rg" value="{{ $dados_pessoas->rg }}" />
        </div>

        <div class="input-group">
            <label for="rg_data_expedicao">Data de Expedição</label>
            <input type="text" name="rg_data_expedicao" id="rg_data_expedicao" class="date-mask" value="{{ $dados_pessoas->rg_data_expedicao }}" />
        </div>

        <div class="input-group">
            <label for="rg_orgao_expedicao">Orgão Expeditor</label>
            <input type="text" name="rg_orgao_expedicao" id="rg_orgao_expedicao" value="{{ $dados_pessoas->rg_orgao_expedicao }}" />
        </div>

        <div class="input-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ $dados_pessoas->email }}" />
        </div>

        <div class="input-group">
            <label for="celular">Celular</label>
            <input type="text" name="celular" id="celular" class="cel-mask" value="{{ $dados_pessoas->telefone }}" />
        </div>

        <div class="input-group">
            <select class="form-select" name="naturalidade_estado">
                <option selecte>Naturalidade / Estado</option>
                @foreach($estados as $sigla => $estado)
                <option value="{{ $sigla }}" {{ $dados_pessoas->naturalidade_estado == $sigla ? "selected" : "" }} >
                    {{ $estado }} 
                </option>
                @endforeach
            </select>
        </div>

        <div class="input-group">
            <label for="naturalidade_cidade">Naturalidade / Cidade</label>
            <input type="text" name="naturalidade_cidade" id="naturalidade_cidade" value="{{ $dados_pessoas->naturalidade_cidade }}"/>
        </div>

        <div class="input-group">
            <label for="nacionalidade">Nacionalidade</label>
            <input type="text" name="nacionalidade" id="nacionalidade" value="{{ $dados_pessoas->nacionalidade }}" />
        </div>

        <div class="input-group">
            <input type="radio" class="btn-check" value="solteiro" name="estado_civil" id="es1" {{ $dados_pessoas->estado_civil == "solteiro" ? "checked" : "" }} >
            <label class="btn btn-outline-danger check-box-btn" for="es1">Solteiro(a)</label>

            <input type="radio" class="btn-check" value="casado" name="estado_civil" id="es2"  {{ $dados_pessoas->estado_civil == "casado" ? "checked" : "" }} >
            <label class="btn btn-outline-danger check-box-btn" for="es2">Casado(a)</label>

            <input type="radio" class="btn-check" value="divorciado" name="estado_civil" id="es3" {{ $dados_pessoas->estado_civil == "divorciado" ? "checked" : "" }} >
            <label class="btn btn-outline-danger check-box-btn" for="es3">Divorciado(a)</label>

            <input type="radio" class="btn-check" value="viuvo" name="estado_civil" id="es4" {{ $dados_pessoas->estado_civil == "viuvo" ? "checked" : "" }} >
            <label class="btn btn-outline-danger check-box-btn" for="es4">Viúvo(a)</label>

            <input type="radio" class="btn-check" value="uniao-estavel" name="estado_civil" id="es5" {{ $dados_pessoas->estado_civil == "uniao-estavel" ? "checked" : "" }} >
            <label class="btn btn-outline-danger" for="es5">União Estável</label>
        </div>

        <div class="input-group">
            <label for="nome_mae">Nome da Mãe</label>
            <input type="text" name="nome_mae" id="nome_mae" value="{{ $dados_pessoas->nome_mae }}" />
        </div>


        <div class="btns-group">
            <button class="btn btn-outline-danger btn-prev" disabled>Anterior</button>
            <button class="btn btn-outline-danger btn-next">Próximo</button>
        </div>
    </div>
    {{-- fim dos dados pessoais --}}




    {{-- ############################## dados de endereço ############################## --}}
    <div class="form-step">
        <div class="input-group">
            <label for="cep">CEP</label>
            <input type="text" name="cep" id="cep" value="{{ $endereco->cep }}" />
        </div>

        <div class="input-group">
            <label for="rua">Rua</label>
            <input type="text" name="rua" id="rua" value="{{ $endereco->rua }}" data-autocomplete-address />
        </div>

        <div class="input-group">
            <label for="numero">Número</label>
            <input type="text" name="numero" id="numero" value="{{ $endereco->numero }}" />
        </div>

        <div class="input-group">
            <label for="bairro">Bairro</label>
            <input type="text" name="bairro" id="bairro" value="{{ $endereco->bairro }}" data-autocomplete-neighborhood />
        </div>

        <div class="input-group">
            <label for="cidade">Cidade</label>
            <input type="text" name="cidade" id="cidade" value="{{ $endereco->cidade }}" data-autocomplete-city />
        </div>

        <div class="input-group">
            <label for="estado">Estado</label>
            <input type="text" name="estado" id="estado" value="{{ $endereco->estado }}" data-autocomplete-state />
        </div>

        <div class="input-group">
            <label for="tipo_residencia">Tipo Residência</label>
            <input type="tipo_residencia" name="tipo_residencia" id="tipo_residencia" value="{{ $endereco->tipo_residencia }}" />
        </div>

        <div class="input-group">
            <label for="reside_desde">Reside Desde</label>
            <input type="text" name="reside_desde" id="reside_desde" class="date-mask" value="{{ $endereco->reside_desde }}" />
        </div>

        <div class="btns-group">
            <button class="btn btn-outline-danger btn-prev">Anterior</button>
            <button class="btn btn-outline-danger btn-next">Próximo</button>
        </div>
    </div>
    {{-- Fim dados de endereço --}}



    {{-- ############################## dados da profissão ############################## --}}
    <div class="form-step">
        <div class="input-group">
            <label for="empresa">Empresa</label>
            <input type="text" name="empresa" id="empresa" value="{{ $dados_profissionais->empresa }}" />
        </div>

        <div class="input-group">
            <label for="telefone_empresa">Telefone</label>
            <input type="text" name="telefone_empresa" id="telefone_empresa" class="tel-mask" value="{{ $dados_profissionais->telefone }}" />
        </div>

        <div class="input-group">
            <label for="salario">Salario</label>
            <input type="text" name="salario" id="salario" class="decimal-change" value="{{ $dados_profissionais->salario }}" />
        </div>

        <div class="input-group">
            <label for="data_admissao">Data de Admissão</label>
            <input type="text" name="data_admissao" id="data_admissao" class="date-mask" value="{{ $dados_profissionais->data_admissao }}" />
        </div>

        <div class="input-group">
            <label for="cargo">Cargo</label>
            <input type="text" name="cargo" id="cargo" value="{{ $dados_profissionais->cargo }}" />
        </div>

        <div class="input-group">
            <label for="ramo_atividade">Ramo de Atividade</label>
            <input type="text" name="ramo_atividade" id="ramo_atividade" value="{{ $dados_profissionais->ramo_atividade }}" />
        </div>

        <div class="btns-group">
            <button class="btn btn-outline-danger btn-prev">Anterior</button>
            <button class="btn btn-outline-danger btn-next">Próximo</button>
        </div>
    </div>
    {{-- Fim dados empresariais --}}


    {{-- ############################## Foto e dados de localização ############################## --}}
    <div class="form-step">
        <div class="input-group container-foto">
            <label for="foto-input" class="btn btn-outline-default foto-label-text" >
                <img id="exibe-img" for="foto-input" class="exibe-img" src="/img/foto/{{ $dados_pessoas->foto }}">
            </label>
            <input id="foto-input" type="file" name="foto" accept="image/*" capture="camera">
        </div>
                
        <div class="btns-group">
            <button class="btn btn-outline-danger btn-prev">Anterior</button>
            <input type="submit" value="Salvar" class="btn btn-outline-success" id="btn-salvar"/>
        </div>
    </div>
    {{-- Fim dados localização --}}
</form>
@endsection
    
