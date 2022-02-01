<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDadosEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dados_empresas', function (Blueprint $table) {
            $table->id();
            $table->string('empresa', 255);
            $table->string('telefone', 11);
            $table->double('salario', 8, 2);
            $table->date('data_admissao');
            $table->string('cargo', 100);
            $table->string('ramo_atividade', 100);
            $table->integer('dados_pessoas_id');
            $table->foreign('dados_pessoas_id')->references('id')->on('dados_pessoas');
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
        Schema::dropIfExists('dados_empresas');
    }
}
