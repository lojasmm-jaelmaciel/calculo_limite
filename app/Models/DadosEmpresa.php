<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DadosEmpresa extends Model
{
    protected $fillable = ['empresa', 'telefone', 'salario', 'data_admissao', 'cargo', 'ramo_atividade', 'dados_pessoas_id'];
    use HasFactory;
}
