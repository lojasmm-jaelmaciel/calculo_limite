<?php

use Illuminate\Support\Facades\File;

/**
 * Segundo as regras impostas, valida os dados digitados no formulário.
 * 
 * @param Request $request
 * 
 * O retorno é imediato para a página do cadastro com as mensagens de erro.
 * No HTML é preciso ter @if($errors->all()) para identifica estes erros.
 * @return Response  $request->validate($regras, $mensagens);
 */
function validaDadosFormulario($request){

    # Sobrescreve as mensagens padrão do sistema, já que o $request->validate() retorna 2 parâmetros
    $mensagens = [
        'cep.min' => 'O "CEP" não está correto',
        'cidade.min' => 'Nome da "CIDADE" muito pequena',
        'estado.max' => 'Precisamos da sigla do "ESTADO"',
        'estado.min' => 'São duas letras a sigla do "ESTADO"',
        'nome.min' => 'O "NOME" só tem uma letra',
        'cpf.min' => 'Você digitou um "CPF" inválido',
        'email.email' => 'Digite um "EMAIL" válido',
        'nacionalidade' => 'Sua "NACIONALIDADE" não está correta',
        'nome_mae.min' => 'Nome da mãe muito curto',
        'empresa' => 'Digite um nome de "EMPRESA" válido',
        'required' => 'O campo ":attribute" é obrigatório!',
    ];

    # Regras inpostas ao formulário para a necessidade de cada input
    $regras = [
        // dados de endereço
        'cep' => 'min:8 | required',
        'rua' => 'required',
        'bairro' => 'required',
        'cidade' => 'min:2 | required',
        'estado' => 'min:2 | max:2 | required',
        'tipo_residencia' => 'required',
        'reside_desde' => 'required',
        // dados pessoais
        'nome' => 'required|min:2',
        'data_nascimento' => 'required',
        'sexo' => 'required',
        'cpf' =>  'required|min:11',
        'rg' => 'required',
        'email' => 'required|email',
        'celular' => 'required',
        'naturalidade_estado' => 'required',
        'naturalidade_cidade' => 'required',
        'nacionalidade' => 'required|min:3',
        'estado_civil' => 'required',
        'nome_mae' => 'min:2 | required',
        // 'foto' => 'required',
        /* dados profissionais */
        'empresa' => 'min:2 | required',
        'telefone_empresa' => 'required',
        'salario' => 'required',
        'data_admissao' => 'required',
        'cargo' => 'required',
        'ramo_atividade' => 'required',
        // 'ip_endereco' => 'required',
        // 'latitude' => 'required',
        // 'longitude' => 'required'
    ];

    # retorno imediato para o HTML sobrescrevendo as regras e as mensagens padrão do sistema
    $request->validate($regras, $mensagens);
}


/**
 * Função que extrai os dados da requisição, criando um array referente a cada  tabela na base de dados. 
 * Por fim cria um array que será retornado para o Controller fazer a persistência dos dados. 
 * Em alguns casos algumas funções são chamadas para padronizar os dados no padrão americano.
 *  - somenteNumeros: retira todo e qualquer caracter que não faz parte do dado numérico
 *  - formataDataEn: transforma a data que vem no padrão pt-br para o padrão americano
 *
 * @param [Request] $request
 * @param [string] $foto_nome
 * @return array
 */
function extraiDadosFormulario($request, $foto_nome = null){

    $dados_endereco = [
        'rua' => $request->rua,
        'numero' => $request->numero,
        'bairro' => $request->bairro,
        'cidade' => $request->cidade,
        'estado' => $request->estado,
        'cep' => somenteNumeros($request->cep),
        'tipo_residencia' => $request->tipo_residencia,
        'reside_desde' => formataDataEn($request->reside_desde)
    ];

        

    if ($request->hasFile('foto') && $request->file('foto')->isValid()){
        
        
        if ($foto_nome != null){
            File::delete(public_path('img/foto/').$foto_nome);
        }

        $requestfoto = $request->foto;
        $extensao = $requestfoto->extension();

        $foto_nome = strtotime("now").".".$extensao;

        $request->foto->move(public_path('img/foto'), $foto_nome);
    }


    $dados_pessoas = [
        'nome' => $request->nome,
        'data_nascimento' => formataDataEn($request->data_nascimento),
        'sexo' => $request->sexo,
        'cpf' =>  somenteNumeros($request->cpf),
        'rg' => somenteNumeros($request->rg),
        'rg_data_expedicao' => formataDataEn($request->rg_data_expedicao),
        'rg_orgao_expedicao' => $request->rg_orgao_expedicao,
        'email' => $request->email,
        'telefone' => somenteNumeros($request->celular),
        'naturalidade_estado' => $request->naturalidade_estado,
        'naturalidade_cidade' => $request->naturalidade_cidade,
        'nacionalidade' => $request->nacionalidade,
        'estado_civil' => $request->estado_civil,
        'nome_mae' => $request->nome_mae,
        'foto' => $foto_nome,
    ];

    
    $dados_profissionais = [
        'empresa' => $request->empresa,
        'telefone' => somenteNumeros($request->telefone_empresa),
        'salario' => str_replace(",", ".", str_replace(".", "", $request->salario)),
        'data_admissao' => formataDataEn($request->data_admissao),
        'cargo' => $request->cargo,
        'ramo_atividade' => $request->ramo_atividade,
    ];

    $dados_localizacao = [
        'ip_endereco' => $request->ip_endereco,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude
    ];
    
    // cria um array de arrays correspondentes a cada tabela no banco de dados.
    $dados_extraidos = [
        'dados_endereco' => $dados_endereco,
        'dados_pessoas' => $dados_pessoas,
        'dados_profissionais' => $dados_profissionais,
        'dados_localizacao' => $dados_localizacao
    ];

    return $dados_extraidos;
}
