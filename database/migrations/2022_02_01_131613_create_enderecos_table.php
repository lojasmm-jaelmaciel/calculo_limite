<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnderecosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enderecos', function (Blueprint $table) {
            $table->id();
            $table->string('rua', 100);
            $table->string('numero', 10);
            $table->string('bairro', 100);
            $table->string('cidade', 100);
            $table->char('estado', 2);
            $table->char('cep', 8);
            $table->string('tipo_residencia', 20);
            $table->date('reside_desde');
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
        Schema::dropIfExists('enderecos');
    }
}
