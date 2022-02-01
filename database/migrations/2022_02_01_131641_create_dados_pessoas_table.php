<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDadosPessoasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dados_pessoas', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 255);
            $table->date('data_nascimento');
            $table->char('sexo', 1);
            $table->char('cpf', 11);
            $table->string('rg', 15);
            $table->date('rg_data_expedicao');
            $table->string('rg_orgao_expedicao', 10);
            $table->string('email', 100);
            $table->char('telefone', 11);
            $table->char('naturalidade_estado', 2);
            $table->string('naturalidade_cidade', 100);
            $table->string('nacionalidade', 20);
            $table->string('estado_civil', 15);
            $table->string('nome_mae', 255);
            $table->string('foto', 50);
            $table->integer('endereco_id');
            $table->foreign('endereco_id')->references('id')->on('enderecos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dados_pessoas');
    }
}
