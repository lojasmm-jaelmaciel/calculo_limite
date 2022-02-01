<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DadosPessoa extends Model
{
    protected $fillable = ['nome', 'data_nascimento', 'sexo', 'cpf', 'rg', 'rg_data_expedicao', 
    'rg_orgao_expedicao',  'email', 'telefone', 'naturalidade_estado', 'uralidade_estado',
    'naturalidade_cidade', 'uralidade_cidade', 'nacionalidade', 'estado_civil', 'nome_mae', 'foto', 'endereco_id'
    ];
    use HasFactory;
}
